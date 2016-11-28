<?php

namespace FL\FacebookPagesBundle\Model;

/**
 * @link https://developers.facebook.com/docs/graph-api/reference/page/ratings/
 */
interface PageReviewInterface
{
    /**
     * @return string|null OpenGraph Story ID
     */
    public function getStoryId();

    /**
     * @param string $storyId OpenGraph Story ID
     *
     * @return PageReviewInterface
     */
    public function setStoryId(string $storyId);

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt();

    /**
     * @param \DateTimeImmutable|null $createdAt
     *
     * @return PageReviewInterface
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt = null): PageReviewInterface;

    /**
     * @return bool
     */
    public function hasRating(): bool;

    /**
     * @return int|null (1-5 stars)
     */
    public function getRating();

    /**
     * @param int $rating (1-5 stars)
     *
     * @return PageReviewInterface
     */
    public function setRating(int $rating): PageReviewInterface;

    /**
     * @return bool
     */
    public function hasText(): bool;

    /**
     * @return string|null
     */
    public function getText();

    /**
     * @param string $review
     *
     * @return PageReviewInterface
     */
    public function setText(string $review): PageReviewInterface;

    /**
     * @return string|null
     */
    public function getReviewerId();

    /**
     * @param string $reviewerId
     *
     * @return PageReviewInterface
     */
    public function setReviewerId(string $reviewerId): PageReviewInterface;

    /**
     * @return string|null
     */
    public function getReviewerName();

    /**
     * @param string $reviewerName
     *
     * @return PageReviewInterface
     */
    public function setReviewerName(string $reviewerName): PageReviewInterface;
}
