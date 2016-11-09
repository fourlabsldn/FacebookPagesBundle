<?php

namespace FL\FacebookPagesBundle\Model\DoctrineORM;

use FL\FacebookPagesBundle\Model\PageInterface;
use FL\FacebookPagesBundle\Model\Page as BasePage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class Page extends BasePage implements PageInterface
{
    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=2048)
     */
    protected $shortLivedToken;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected $shortLivedTokenExpiration;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=2048)
     */
    protected $longLivedToken;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    protected $longLivedTokenExpiration;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=2048)
     */
    protected $pageId;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=2048)
     */
    protected $pageName;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true, length=2048)
     */
    protected $category;
}
