<?php

namespace FL\FacebookPagesBundle\Storage;

use FL\FacebookPagesBundle\Model\FacebookUserInterface;

interface PageManagerStorageInterface
{
    /**
     * @return FacebookUserInterface[]
     */
    public function getAll(): array;

    /**
     * @param FacebookUserInterface $facebookUser
     *
     * @return PageManagerStorageInterface
     */
    public function persist(FacebookUserInterface $facebookUser): PageManagerStorageInterface;

    /**
     * @param FacebookUserInterface[] $facebookUsers
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
