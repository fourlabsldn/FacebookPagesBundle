<?php

namespace FL\FacebookPagesBundle\Action;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizeFacebook
{
    /**
     * @var FacebookUserClient
     */
    private $facebookUserClient;

    /**
     * @var string[]
     */
    private $permissions;

    /**
     * @var string
     */
    private $callbackUrl;

    /**
     * @param FacebookUserClient $facebookUserClient
     * @param string             $callBackUrl
     * @param array              $permissions
     *
     * @link https://developers.facebook.com/docs/facebook-login/permissions
     */
    public function __construct(FacebookUserClient $facebookUserClient, string $callBackUrl, array $permissions = ['id'])
    {
        $this->facebookUserClient = $facebookUserClient;
        $this->callbackUrl = $callBackUrl;
        $this->permissions = $permissions;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $helper = $this->facebookUserClient->getRedirectLoginHelper();

        return new RedirectResponse($helper->getLoginUrl($this->callbackUrl, $this->permissions));
    }
}
