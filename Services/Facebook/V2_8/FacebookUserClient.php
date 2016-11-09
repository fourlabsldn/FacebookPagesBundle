<?php

namespace FL\FacebookPagesBundle\Services\Facebook\V2_8;

use Facebook\Facebook;
use Facebook\FacebookResponse;
use FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient;
use FL\FacebookPagesBundle\Model\FacebookUserInterface;

class FacebookUserClient
{
    /**
     * @var Facebook
     */
    private $client;

    /**
     * @param string            $appId
     * @param string            $appSecret
     * @param Guzzle6HttpClient $guzzle6HttpClient
     */
    public function __construct(string $appId, string $appSecret, Guzzle6HttpClient $guzzle6HttpClient = null)
    {
        if ($guzzle6HttpClient === null) {
            $guzzle6HttpClient = new Guzzle6HttpClient(new \GuzzleHttp\Client());
        }

        $this->client = new Facebook([
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

        return $this->client->get($endpoint, $facebookUser->getLongLivedToken(), null, null);
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
        return $this->client->getRedirectLoginHelper()->getLoginUrl(
            $callbackUrl,
            ['public_profile', 'email', 'manage_pages', 'publish_pages', 'pages_messaging']
        );
    }
}
