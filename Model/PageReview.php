<?php

namespace FL\FacebookPagesBundle\Model;

/**
 * @link https://developers.facebook.com/docs/graph-api/reference/page/ratings/
 */
class PageReview implements PageReviewInterface
{
    /**
     * @var string|null
     */
    protected $storyId;

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
    protected $text;

    /**
     * @var string|null
     */
    protected $reviewerId;

    /**
     * @var string|null
     */
    protected $reviewerName;

    /**
     * {@inheritdoc}
     */
    public function getStoryId()
    {
        return $this->storyId;
    }

    /**
     * {@inheritdoc}
     */
    public function setStoryId(string $storyId)
    {
        $this->storyId = $storyId;

        return $this;
    }

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
    public function setCreatedAt(\DateTimeImmutable $createdAt = null): PageReviewInterface
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasRating(): bool
    {
        return is_int($this->rating);
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
    public function setRating(int $rating = null): PageReviewInterface
    {
        $this->rating = $rating;
        if (is_int($rating) && ($rating >= 6 || $rating <= 0)) {
            throw new \InvalidArgumentException();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasText(): bool
    {
        return is_string($this->text);
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * {@inheritdoc}
     */
    public function setText(string $text): PageReviewInterface
    {
        $this->text = $text;

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
    public function setReviewerId(string $reviewerId): PageReviewInterface
    {
        $this->reviewerId = $reviewerId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReviewerName()
    {
        return $this->reviewerName;
    }

    /**
     * {@inheritdoc}
     */
    public function setReviewerName(string $reviewerName): PageReviewInterface
    {
        $this->reviewerName = $reviewerName;

        return $this;
    }
}
