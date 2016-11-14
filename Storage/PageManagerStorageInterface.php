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
     * @param PageManagerInterface $facebookUser
     *
     * @return PageManagerStorageInterface
     */
    public function persist(PageManagerInterface $facebookUser): PageManagerStorageInterface;

    /**
     * @param PageManagerInterface[] $facebookUsers
     *
     * @return PageManagerStorageInterface
     */
    public function persistMultiple(array $facebookUsers): PageManagerStorageInterface;

    /**
     * Deletes all page managers.
     *
     * @return PageManagerStorageInterface
     */
    public function clearAll(): PageManagerStorageInterface;
}
