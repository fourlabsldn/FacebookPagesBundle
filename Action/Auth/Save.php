<?php

namespace FL\FacebookPagesBundle\Action\Auth;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\PageManagerClient;
use FL\FacebookPagesBundle\Storage\PageManagerStorageInterface;
use FL\FacebookPagesBundle\Storage\PageStorageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Save
{
    /**
     * @var PageManagerClient
     */
    private $pageManagerClient;

    /**
     * @var PageManagerStorageInterface
     */
    private $pageManagerStorage;

    /**
     * @var PageStorageInterface
     */
    private $pageStorage;

    /**
     * @var string
     */
    private $redirectAfterAuthorization;

    /**
     * @var null|string[]
     */
    private $onlyThesePageIds;

    /**
     * @param PageManagerClient            $pageManagerClient
     * @param PageManagerStorageInterface  $pageManagerStorage
     * @param PageStorageInterface         $pageStorage
     * @param string                       $redirectAfterAuthorization
     * @param string[]                     $onlyThesePageIds
     *
     * @link https://developers.facebook.com/docs/facebook-login/permissions
     */
    public function __construct(
        PageManagerClient $pageManagerClient,
        PageManagerStorageInterface $pageManagerStorage,
        PageStorageInterface $pageStorage,
        string $redirectAfterAuthorization,
        array $onlyThesePageIds = null
    ) {
        $this->pageManagerClient = $pageManagerClient;
        $this->pageManagerStorage = $pageManagerStorage;
        $this->pageStorage = $pageStorage;
        $this->redirectAfterAuthorization = $redirectAfterAuthorization;
        $this->onlyThesePageIds = $onlyThesePageIds;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $user = $this->pageManagerClient->generateUserFromAuthorizationRequest($request);

        $userPages = $this->pageManagerClient->resolveUserPages($user);
        if ($this->onlyThesePageIds === null || count($this->onlyThesePageIds) === 0) {
            $this->pageStorage->persistMultiple($userPages);

            return new RedirectResponse($this->redirectAfterAuthorization);
        }

        $pagesToPersist = [];
        foreach ($userPages as $page) {
            if (in_array($page->getPageId(), $this->onlyThesePageIds)) {
                $pagesToPersist[] = $page;
            }
        }
        $this->pageStorage->persistMultiple($pagesToPersist);

        return new RedirectResponse($this->redirectAfterAuthorization);
    }
}
