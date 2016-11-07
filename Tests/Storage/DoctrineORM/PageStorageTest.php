<?php

namespace FL\FacebookPagesBundle\Tests\Storage\DoctrineORM;

use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageInterface;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage;
use FL\FacebookPagesBundle\Tests\Util\Storage\DoctrineORM\ManagerAndRepositoryTest;

class PageStorageTest extends ManagerAndRepositoryTest
{
    public function setUp()
    {
        $this->findAllReturnValue = [new Page(), new Page()];
        parent::setUp();
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage::getAll
     */
    public function testGetAll()
    {
        $this->entityManager->clear();
        $pageStorage = new PageStorage(
            $this->entityManager,
            PageStorage::class
        );
        $this->assertInternalType('array', $pageStorage->getAll());
        foreach ($pageStorage->getAll() as $page) {
            $this->assertInstanceOf(PageInterface::class, $page);
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage::persist
     */
    public function testPersist()
    {
        $pageStorage = new PageStorage(
            $this->entityManager,
            PageStorage::class
        );

        $pageA = new Page();
        $pageStorage->persist($pageA);
        $this->assertContains($pageA, $this->persistedEntities);
        $this->assertContains($pageA, $this->persistedAndFlushedEntities);

        $pageB = new Page();
        $pageStorage->persist($pageB);
        $this->assertNotContains($pageA, $this->persistedEntities);
        $this->assertContains($pageB, $this->persistedEntities);
        $this->assertContains($pageA, $this->persistedAndFlushedEntities);
        $this->assertContains($pageB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage::persistMultiple
     */
    public function testPersistMultiple()
    {
        $pageStorage = new PageStorage(
            $this->entityManager,
            PageStorage::class
        );

        $pageA = new Page();
        $pageB = new Page();

        $pageStorage->persistMultiple([$pageA, $pageB]);
        $this->assertContains($pageA, $this->persistedEntities);
        $this->assertContains($pageB, $this->persistedEntities);
        $this->assertContains($pageA, $this->persistedAndFlushedEntities);
        $this->assertContains($pageB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage::persistMultiple
     */
    public function testPersistMultipleException()
    {
        $pageStorage = new PageStorage(
            $this->entityManager,
            PageStorage::class
        );

        $page = new Page();
        $date = new \DateTimeImmutable();

        try {
            $pageStorage->persistMultiple([$page, $date]);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        $this->fail(sprintf(
            'Expected %s for invalid %s::persistMultiple',
            \InvalidArgumentException::class,
            Page::class
        ));
    }
}
