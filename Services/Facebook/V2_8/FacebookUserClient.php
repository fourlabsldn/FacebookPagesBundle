<?php

namespace FL\FacebookPagesBundle\Services\Facebook\V2_8;

use Facebook\Authentication\AccessToken;
use Facebook\Facebook;
use Facebook\FacebookResponse;
use FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient;
use FL\FacebookPagesBundle\Model\FacebookUserInterface;
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
     * @var Guzzle6HttpClient
     */
    private $guzzleClient;

    /**
     * @param string            $appId
     * @param string            $appSecret
     * @param Guzzle6HttpClient $guzzle6HttpClient
     */
    public function __construct(
        string $appId,
        string $appSecret,
        string $userClass,
        Guzzle6HttpClient $guzzle6HttpClient = null
    ) {
        if ($guzzle6HttpClient === null) {
            $guzzle6HttpClient = new Guzzle6HttpClient(new \GuzzleHttp\Client());
        }

        $this->appId = $appId;
        $this->appSecret = $appSecret;
        $this->userClass = $userClass;

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
    public function generateUserFromRequest(Request $authorizeFacebookRequest)
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
}
