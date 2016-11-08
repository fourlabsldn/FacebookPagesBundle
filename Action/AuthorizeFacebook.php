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
     */
    public function __construct(
        FacebookUserClient $facebookUserClient,
        string $callBackUrl,
        array $permissions
    ) {
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
        return new RedirectResponse($this->facebookUserClient->generateAuthorizationUrl($this->callbackUrl, $this->permissions));
    }
}