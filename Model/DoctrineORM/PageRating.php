<?php

namespace FL\FacebookPagesBundle\Model\DoctrineORM;

use FL\FacebookPagesBundle\Model\PageRatingInterface;
use FL\FacebookPagesBundle\Model\PageRating as BasePageRating;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class PageRating extends BasePageRating implements PageRatingInterface
{
    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    protected $createdAt;

    /**
     * @var int|null (1-5 stars)
     * @ORM\Column(type="smallint", nullable=true)
     */
    protected $rating;

    /**
     * @var string|null
     * @ORM\Column(type="test", nullable=true)
     */
    protected $review;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=2048)
     */
    protected $reviewerId;
}
