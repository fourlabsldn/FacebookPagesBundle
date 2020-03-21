<?php

namespace FL\FacebookPagesBundle\Services\Facebook;

use Facebook\Authentication\AccessToken;
use Facebook\Facebook;
use Facebook\Response;
use Facebook\GraphNode\GraphNode;
use Facebook\Url\UrlManipulator;
use FL\FacebookPagesBundle\Model\PageManagerInterface;
use FL\FacebookPagesBundle\Model\PageInterface;
use FL\FacebookPagesBundle\Model\PageReviewInterface;
use Symfony\Component\HttpFoundation\Request;

class PageManagerClient
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $userClass;

    /**
     * @var string
     */
    private $pageClass;

    /**
     * @var string
     */
    private $pageReviewClass;

    /**
     * @var Facebook
     */
    private $guzzleClient;

    public function __construct(
        string $appId,
        string $userClass,
        string $pageClass,
        string $pageReviewClass,
        Facebook $facebookClient
    ) {
        $this->appId = $appId;
        $this->userClass = $userClass;
        $this->pageClass = $pageClass;
        $this->pageReviewClass = $pageReviewClass;
        $this->guzzleClient = $facebookClient;
    }

    /**
     * @param string               $endpoint
     * @param PageManagerInterface $pageManager
     *
     * @return Response
     */
    public function get(string $endpoint, PageManagerInterface $pageManager)
    {
        if (null === $pageManager->getLongLivedToken()) {
            throw new \InvalidArgumentException();
        }

        return $this->guzzleClient->get($endpoint, $pageManager->getLongLivedToken(), null, null);
    }

    /**
     * This could become a separate client in the future.
     *
     * @param string        $endpoint
     * @param PageInterface $facebookPage
     *
     * @return Response
     */
    public function getWithPage(string $endpoint, PageInterface $facebookPage)
    {
        if (null === $facebookPage->getLongLivedToken()) {
            throw new \InvalidArgumentException();
        }

        return $this->guzzleClient->get($endpoint, $facebookPage->getLongLivedToken(), null, null);
    }

    /**
     * @param string $callbackUrl
     *
     * @see https://developers.facebook.com/docs/facebook-login/permissions
     *
     * @return string
     */
    public function generateAuthorizationUrl(string $callbackUrl)
    {
        return $this->guzzleClient->getRedirectLoginHelper()->getLoginUrl(
            $callbackUrl,
            [
                'manage_pages',
            ]
        );
    }

    /**
     * @param Request $authorizeFacebookRequest
     *
     * @return PageManagerInterface
     */
    public function generateUserFromAuthorizationRequest(Request $authorizeFacebookRequest): PageManagerInterface
    {
        $token = $this->generateLongLivedTokenFromUrl($authorizeFacebookRequest->getUri());
        $response = $this->guzzleClient->get('/me', $token->getValue());
        $graphUser = $response->getGraphUser();

        /** @var PageManagerInterface $user */
        $user = (new $this->userClass());
        $expiration = $token->getExpiresAt() ? \DateTimeImmutable::createFromMutable($token->getExpiresAt()) : null;
        $user
            ->setLongLivedTokenExpiration($expiration)
            ->setLongLivedToken($token->getValue())
            ->setUserId($graphUser->getId())
        ;

        return $user;
    }

    /**
     * @param string $url
     *
     * @return AccessToken
     *
     * @throws \InvalidArgumentException
     */
    private function generateLongLivedTokenFromUrl(string $url): AccessToken
    {
        $helper = $this->guzzleClient->getRedirectLoginHelper();
        $oAuth2Client = $this->guzzleClient->getOAuth2Client();

        // we need a clean redirect URL for Facebook's strict matching policy
        $redirectUrl = UrlManipulator::removeParamsFromUrl($url, ['state', 'code']);
        $accessToken = $helper->getAccessToken($redirectUrl);

        if (!isset($accessToken)) {
            throw new \InvalidArgumentException();
        }
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        $tokenMetadata->validateAppId($this->appId);
        $tokenMetadata->validateExpiration();

        if (!$accessToken->isLongLived()) {
            $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        }

        return $accessToken;
    }

    /**
     * @param PageManagerInterface $pageManager
     *
     * @return PageInterface[]
     */
    public function resolveUserPages(PageManagerInterface $pageManager)
    {
        $response = $this->get('/me/accounts', $pageManager);
        $fullyAdminedPages = [];

        /** @var GraphNode $pageGraphNode */
        foreach ($response->getGraphEdge()->all() as $pageGraphNode) {
            if (in_array('MANAGE', $pageGraphNode->getField('tasks')->asArray())) {
                /** @var PageInterface $page */
                $page = new $this->pageClass();
                $page
                    ->setLongLivedToken($pageGraphNode->getField('access_token'))
                    ->setLongLivedTokenExpiration(null)
                    ->setPageId($pageGraphNode->getField('id'))
                    ->setPageName($pageGraphNode->getField('name'))
                    ->setCategory($pageGraphNode->getField('category'))
                    ->setPageManager($pageManager)
                ;
                $fullyAdminedPages[] = $page;
            }
        }

        return $fullyAdminedPages;
    }

    /**
     * @param PageInterface $page
     *
     * @return PageReviewInterface[]
     */
    public function resolvePageReviews(PageInterface $page): array
    {
        $allReviews = [];

        $reviewsEdge = $this->getWithPage(
            sprintf(
            '/%s/ratings?fields=id,created_time,reviewer,rating,review_text,open_graph_story',
            $page->getPageId()
        ),
            $page
        )->getGraphEdge();

        do {
            /** @var GraphNode $reviewGraphNode */
            foreach ($reviewsEdge->all() as $reviewGraphNode) {
                /** @var GraphNode $reviewerGraphNode */
                $reviewerGraphNode = $reviewGraphNode->getField('reviewer');

                /** @var PageReviewInterface $review */
                $review = new $this->pageReviewClass();
                $review
                    ->setReviewerId($reviewerGraphNode->getField('id'))
                    ->setReviewerName($reviewerGraphNode->getField('name'))
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($reviewGraphNode->getField('created_time')))
                ;

                if ($reviewGraphNode->getField('review_text')) {
                    $review->setText($reviewGraphNode->getField('review_text'));
                }

                if ($reviewGraphNode->getField('rating')) {
                    $review->setRating($reviewGraphNode->getField('rating'));
                }

                if ($reviewGraphNode->getField('open_graph_story')) {
                    $review->setStoryId($reviewGraphNode->getField('open_graph_story')->getField('id'));
                }

                $allReviews[] = $review;
            }
        } while (($reviewsEdge = $this->guzzleClient->next($reviewsEdge)));

        return $allReviews;
    }
}
