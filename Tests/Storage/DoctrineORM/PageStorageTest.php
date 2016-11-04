<?php

namespace FL\FacebookPagesBundle\Tests\Storage\DoctrineORM;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageInterface;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage;

class PageStorageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function setUp()
    {
        $this->entityRepository = $this
            ->getMockBuilder(EntityRepository::class)
            ->setMethods(['findAll'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->entityRepository
            ->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue([new Page(), new Page()]))
        ;

        $this->entityManager = $this
            ->getMockBuilder(EntityManager::class)
            ->setMethods(['clear', 'persist', 'flush', 'getRepository', 'getUnitOfWork'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $this->entityManager
            ->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($this->entityRepository))
        ;
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage::getAll
     */
    public function testFindAll()
    {
        $pageStorage = new PageStorage(
            $this->entityManager,
            PageStorage::class
        );
        $this->assertInternalType('array', $pageStorage->getAll());
        foreach ($pageStorage->getAll() as $page) {
            $this->assertInstanceOf(PageInterface::class, $page);
        }
    }
}
