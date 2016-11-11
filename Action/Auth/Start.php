<?php

namespace FL\FacebookPagesBundle\Action\Auth;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class Start
{
    /**
     * @var FacebookUserClient
     */
    private $facebookUserClient;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param FacebookUserClient $facebookUserClient
     * @param RouterInterface $router
     */
    public function __construct(
        FacebookUserClient $facebookUserClient,
        RouterInterface $router
    ) {
        $this->facebookUserClient = $facebookUserClient;
        $this->router = $router;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        return new RedirectResponse(
            $this->facebookUserClient->generateAuthorizationUrl(
                $this->router->generate('fl_facebook_pages_routes.save_auth', [], RouterInterface::ABSOLUTE_URL)
            )
        );
    }
}
