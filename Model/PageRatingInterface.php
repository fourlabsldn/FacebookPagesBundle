<?php

namespace FL\FacebookPagesBundle\Model;

/**
 * @link https://developers.facebook.com/docs/graph-api/reference/page/ratings/
 */
interface PageRatingInterface
{
    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt();

    /**
     * @param \DateTimeImmutable|null $createdAt
     *
     * @return PageRatingInterface
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt = null): PageRatingInterface;

    /**
     * @return bool
     */
    public function hasRating(): bool;

    /**
     * @return int|null (1-5 stars)
     */
    public function getRating();

    /**
     * @param int|null $rating (1-5 stars)
     *
     * @return PageRatingInterface
     */
    public function setRating(int $rating = null): PageRatingInterface;

    /**
     * @return bool
     */
    public function hasReview(): bool;

    /**
     * @return string|null
     */
    public function getReview();

    /**
     * @param string|null $review
     *
     * @return PageRatingInterface
     */
    public function setReview(string $review = null): PageRatingInterface;

    /**
     * @return string|null
     */
    public function getReviewerId();

    /**
     * @param string|null $reviewerId
     *
     * @return PageRatingInterface
     */
    public function setReviewerId(string $reviewerId = null): PageRatingInterface;
}
