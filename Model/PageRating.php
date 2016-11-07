<?php

namespace FL\FacebookPagesBundle\Model;

/**
 * @link https://developers.facebook.com/docs/graph-api/reference/page/ratings/
 */
class PageRating implements PageRatingInterface
{
    /**
     * @var \DateTimeImmutable|null
     */
    protected $createdAt;

    /**
     * @var int|null (1-5 stars)
     */
    protected $rating;

    /**
     * @var string|null
     */
    protected $review;

    /**
     * @var string|null
     */
    protected $reviewerId;

    /**
     * {@inheritdoc}
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * {@inheritdoc}
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt = null): PageRatingInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRating(): bool
    {
        if (is_int($this->rating)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \InvalidArgumentException
     */
    public function setRating(int $rating = null): PageRatingInterface
    {
        $this->rating = $rating;
        if (
            is_int($rating) &&
            $rating >= 6 &&
            $rating <= 0
        ) {
            throw new \InvalidArgumentException();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasReview(): bool
    {
        if (is_string($this->rating)) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function getReview()
    {
        return $this->review;
    }

    /**
     * {@inheritdoc}
     */
    public function setReview(string $review = null): PageRatingInterface
    {
        $this->review = $review;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReviewerId()
    {
        return $this->reviewerId;
    }

    /**
     * {@inheritdoc}
     */
    public function setReviewerId(string $reviewerId = null): PageRatingInterface
    {
        $this->reviewerId = $reviewerId;

        return $this;
    }
}
