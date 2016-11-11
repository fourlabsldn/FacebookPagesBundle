<?php

namespace FL\FacebookPagesBundle\Action\Auth;

use FL\FacebookPagesBundle\Storage\PageManagerStorageInterface;
use FL\FacebookPagesBundle\Storage\PageStorageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class Clear
{
    /**
     * @var PageManagerStorageInterface
     */
    private $pageManagerStorage;

    /**
     * @var PageStorageInterface
     */
    private $pageStorage;

    private $redirectAfterAuthorization;

    /**
     * @param PageManagerStorageInterface $pageManagerStorage
     * @param PageStorageInterface $pageStorage
     * @param string $redirectAfterAuthorization
     */
    public function __construct(
        PageManagerStorageInterface $pageManagerStorage,
        PageStorageInterface $pageStorage,
        string $redirectAfterAuthorization
    )
    {
        $this->pageManagerStorage = $pageManagerStorage;
        $this->pageStorage = $pageStorage;
        $this->redirectAfterAuthorization = $redirectAfterAuthorization;
    }

    /**
     * @return RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        $this->pageStorage->clearAll();
        $this->pageManagerStorage->clearAll();

        return new RedirectResponse($this->redirectAfterAuthorization);
    }
}
