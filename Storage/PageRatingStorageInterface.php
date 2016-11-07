<?php

namespace FL\FacebookPagesBundle\Storage;

use FL\FacebookPagesBundle\Model\PageRatingInterface;

interface PageRatingStorageInterface
{
    /**
     * @return PageRatingInterface[]
     */
    public function getAll(): array;

    /**
     * @param PageRatingInterface $page
     *
     * @return PageRatingStorageInterface
     */
    public function persist(PageRatingInterface $page): PageRatingStorageInterface;

    /**
     * @param PageRatingInterface[] $pages
     *
     * @return PageRatingStorageInterface
     */
    public function persistMultiple(array $pages): PageRatingStorageInterface;
}
