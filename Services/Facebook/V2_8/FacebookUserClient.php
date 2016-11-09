<?php

namespace FL\FacebookPagesBundle\Services\Facebook\V2_8;

use Facebook\Authentication\AccessToken;
use Facebook\Facebook;
use Facebook\FacebookResponse;
use Facebook\GraphNodes\GraphNode;
use FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient;
use FL\FacebookPagesBundle\Model\FacebookUserInterface;
use FL\FacebookPagesBundle\Model\PageInterface;
use Symfony\Component\HttpFoundation\Request;

class FacebookUserClient
{
    /**
     * @var string
     */
    private $appId;

    /**
     * @var string
     */
    private $appSecret;

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
    private $pageRatingClass;

    /**
     * @var Guzzle6HttpClient
     */
    private $guzzleClient;

    /**
     * FacebookUserClient constructor.
     *
     * @param string                 $appId
     * @param string                 $appSecret
     * @param string                 $userClass
     * @param string                 $pageClass
     * @param string                 $pageRatingClass
     * @param Guzzle6HttpClient|null $guzzle6HttpClient
     */
    public function __construct(
        string $appId,
        string $appSecret,
        string $userClass,
        string $pageClass,
        string $pageRatingClass,
        Guzzle6HttpClient $guzzle6HttpClient = null
    ) {
        if ($guzzle6HttpClient === null) {
            $guzzle6HttpClient = new Guzzle6HttpClient(new \GuzzleHttp\Client());
        }

        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->userClass = $userClass;
        $this->pageClass = $pageClass;
        $this->pageRatingClass = $pageRatingClass;
        $this->guzzleClient = new Facebook([
            'app_id' => $appId,
            'app_secret' => $appSecret,
            'default_graph_version' => 'v2.8',
            'enable_beta_mode' => false,
            'http_client_handler' => $guzzle6HttpClient,
            'persistent_data_handler' => null,
            'pseudo_random_string_generator' => null,
            'url_detection_handler' => null,
        ]);
    }

    /**
     * @param $endpoint
     * @param FacebookUserInterface $facebookUser
     *
     * @return FacebookResponse
     */
    public function get($endpoint, FacebookUserInterface $facebookUser)
    {
        if ($facebookUser->getLongLivedToken() === null) {
            throw new \InvalidArgumentException();
        }

        return $this->guzzleClient->get($endpoint, $facebookUser->getLongLivedToken(), null, null);
    }

    /**
     * @param string $callbackUrl
     *
     * @link https://developers.facebook.com/docs/facebook-login/permissions
     *
     * @return string
     */
    public function generateAuthorizationUrl(string $callbackUrl)
    {
        return $this->guzzleClient->getRedirectLoginHelper()->getLoginUrl(
            $callbackUrl,
            ['public_profile', 'email', 'manage_pages', 'publish_pages', 'pages_messaging']
        );
    }

    /**
     * @param Request $authorizeFacebookRequest
     *
     * @return FacebookUserInterface
     */
    public function generateUserFromAuthorizationRequest(Request $authorizeFacebookRequest): FacebookUserInterface
    {
        $token = $this->generateLongLivedTokenFromUrl($authorizeFacebookRequest->getUri());
        $response = $this->guzzleClient->get('/me', $token->getValue());
        $graphUser = $response->getGraphUser();
        /** @var FacebookUserInterface $user */
        $user = (new $this->userClass());
        $user
            ->setLongLivedTokenExpiration(\DateTimeImmutable::createFromMutable($token->getExpiresAt()))
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

        $accessToken = $helper->getAccessToken($url);

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
     * @param FacebookUserInterface $facebookUser
     *
     * @return PageInterface[]
     */
    public function resolveUserPages(FacebookUserInterface $facebookUser)
    {
        $response = $this->get('/me/accounts', $facebookUser);
        $fullyAdminedPages = [];

        /** @var GraphNode $pageGraphNode */
        foreach ($response->getGraphEdge()->all() as $pageGraphNode) {
            /** @var GraphNode $permissions */
            $permissions = $pageGraphNode->getField('perms');
            if (
                is_array($permissions->uncastItems()) &&
                in_array('ADMINISTER', $permissions->uncastItems())
            ) {
                /** @var PageInterface $page */
                $page = new $this->pageClass();
                $page
                    ->setPageId($pageGraphNode->getField('id'))
                    ->setPageName($pageGraphNode->getField('name'))
                    ->setCategory($pageGraphNode->getField('category'))
                ;
                $fullyAdminedPages[] = $page;
            }
        }

        return $fullyAdminedPages;
    }
}
