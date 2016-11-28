<?php

namespace FL\FacebookPagesBundle\Action\Auth;

use FL\FacebookPagesBundle\Storage\PageManagerStorageInterface;
use FL\FacebookPagesBundle\Storage\PageReviewStorageInterface;
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

    /**
     * @var PageReviewStorageInterface
     */
    private $pageReviewStorage;

    /**
     * @var string
     */
    private $redirectAfterAuthorization;

    /**
     * @param PageManagerStorageInterface $pageManagerStorage
     * @param PageStorageInterface        $pageStorage
     * @param PageReviewStorageInterface  $pageReviewStore
     * @param string                      $redirectAfterAuthorization
     */
    public function __construct(
        PageManagerStorageInterface $pageManagerStorage,
        PageStorageInterface $pageStorage,
        PageReviewStorageInterface $pageReviewStore,
        string $redirectAfterAuthorization
    ) {
        $this->pageManagerStorage = $pageManagerStorage;
        $this->pageStorage = $pageStorage;
        $this->pageReviewStorage = $pageReviewStore;
        $this->redirectAfterAuthorization = $redirectAfterAuthorization;
    }

    /**
     * @return RedirectResponse
     */
    public function __invoke(): RedirectResponse
    {
        $this->pageStorage->clearAll();
        $this->pageManagerStorage->clearAll();
        $this->pageReviewStorage->clearAll();

        return new RedirectResponse($this->redirectAfterAuthorization);
    }
}
