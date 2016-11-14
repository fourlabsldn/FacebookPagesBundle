<?php

namespace FL\FacebookPagesBundle\Model;

/**
 * @link https://developers.facebook.com/docs/graph-api/reference/page/ratings/
 */
class PageReview implements PageReviewInterface
{
    /**
     * @var
     */
    protected $storyId;

    /**
     * @var \DateTimeImmutable|null
     */
    protected $createdAt;

    /**
     * @var int|null (1-5 stars)
     */
    protected $review;

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
    public function hasReview(): bool
    {
        if (is_int($this->review)) {
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
     *
     * @throws \InvalidArgumentException
     */
    public function setReview(int $review = null): PageReviewInterface
    {
        $this->review = $review;
        if (
            is_int($review) &&
            ($review >= 6 || $review <= 0)
        ) {
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
