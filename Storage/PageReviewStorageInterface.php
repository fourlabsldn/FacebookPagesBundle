<?php

namespace FL\FacebookPagesBundle\Storage;

use FL\FacebookPagesBundle\Model\PageReviewInterface;

interface PageReviewStorageInterface
{
    /**
     * @return PageReviewInterface[]
     */
    public function getAll(): array;

    /**
     * @param PageReviewInterface $page
     *
     * @return PageReviewStorageInterface
     */
    public function persist(PageReviewInterface $page): PageReviewStorageInterface;

    /**
     * @param PageReviewInterface[] $pages
     *
     * @return PageReviewStorageInterface
     */
    public function persistMultiple(array $pages): PageReviewStorageInterface;
}
