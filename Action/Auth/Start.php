<?php

namespace FL\FacebookPagesBundle\Action\Auth;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\PageManagerClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class Start
{
    /**
     * @var PageManagerClient
     */
    private $pageManagerClient;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param PageManagerClient $pageManagerClient
     * @param RouterInterface $router
     */
    public function __construct(
        PageManagerClient $pageManagerClient,
        RouterInterface $router
    ) {
        $this->pageManagerClient = $pageManagerClient;
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
            $this->pageManagerClient->generateAuthorizationUrl(
                $this->router->generate('fl_facebook_pages_routes.save_auth', [], RouterInterface::ABSOLUTE_URL)
            )
        );
    }
}
