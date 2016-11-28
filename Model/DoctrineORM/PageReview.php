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
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $storyId;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected $createdAt;

    /**
     * @var int|null (1-5 stars)
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $rating;

    /**
     * @var string|null
     * @ORM\Column(type="text", nullable=true)
     */
    protected $text;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, unique=true)
     */
    protected $reviewerId;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected $reviewerName;
}
