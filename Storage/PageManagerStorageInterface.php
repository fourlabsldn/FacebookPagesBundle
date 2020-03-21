<?php

namespace FL\FacebookPagesBundle\Storage;

use FL\FacebookPagesBundle\Model\PageManagerInterface;

interface PageManagerStorageInterface
{
    /**
     * @return PageManagerInterface[]
     */
    public function getAll(): array;

    /**
     * @param PageManagerInterface $pageManager
     *
     * @return PageManagerStorageInterface
     */
    public function persist(PageManagerInterface $pageManager): self;

    /**
     * @param PageManagerInterface[] $pageManagers
     *
     * @return PageManagerStorageInterface
     */
    public function persistMultiple(array $pageManagers): self;

    /**
     * Deletes all page managers.
     *
     * @return PageManagerStorageInterface
     */
    public function clearAll(): self;
}
