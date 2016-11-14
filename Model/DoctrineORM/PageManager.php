<?php

namespace FL\FacebookPagesBundle\Model\DoctrineORM;

use FL\FacebookPagesBundle\Model\PageManagerInterface;
use FL\FacebookPagesBundle\Model\PageManager as BasePageManager;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class PageManager extends BasePageManager implements PageManagerInterface
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
    protected $userId;
}
