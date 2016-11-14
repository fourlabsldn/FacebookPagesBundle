<?php

namespace FL\FacebookPagesBundle\Model\DoctrineORM;

use FL\FacebookPagesBundle\Model\PageReviewInterface;
use FL\FacebookPagesBundle\Model\PageReview as BasePageReview;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class PageReview extends BasePageReview implements PageReviewInterface
{
    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected $createdAt;

    /**
     * @var int|null (1-5 stars)
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $review;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    protected $text;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=2048)
     */
    protected $reviewerId;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=2048)
     */
    protected $reviewerName;
}
