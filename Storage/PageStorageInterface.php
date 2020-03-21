<?php

namespace FL\FacebookPagesBundle\Storage;

use FL\FacebookPagesBundle\Model\PageInterface;

interface PageStorageInterface
{
    /**
     * @return PageInterface[]
     */
    public function getAll(): array;

    /**
     * @param PageInterface $page
     *
     * @return PageStorageInterface
     */
    public function persist(PageInterface $page): self;

    /**
     * @param PageInterface[] $pages
     *
     * @return PageStorageInterface
     */
    public function persistMultiple(array $pages): self;

    /**
     * Deletes all pages.
     *
     * @return PageStorageInterface
     */
    public function clearAll(): self;
}
