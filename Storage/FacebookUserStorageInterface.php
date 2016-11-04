<?php

namespace FL\FacebookPagesBundle\Storage;

use FL\FacebookPagesBundle\Model\FacebookUserInterface;

interface FacebookUserStorageInterface
{
    /**
     * @return FacebookUserInterface[]
     */
    public function getAll(): array;

    /**
     * @param FacebookUserInterface $facebookUser
     *
     * @return FacebookUserStorageInterface
     */
    public function persist(FacebookUserInterface $facebookUser): FacebookUserStorageInterface;

    /**
     * @param FacebookUserInterface[] $facebookUsers
     *
     * @return FacebookUserStorageInterface
     */
    public function persistMultiple(array $facebookUsers): FacebookUserStorageInterface;
}
