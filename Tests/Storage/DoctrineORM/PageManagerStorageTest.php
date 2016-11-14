<?php

namespace FL\FacebookPagesBundle\Tests\Storage\DoctrineORM;

use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\PageManagerInterface;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage;
use FL\FacebookPagesBundle\Tests\Util\Storage\DoctrineORM\ManagerAndRepositoryTest;

class PageManagerStorageTest extends ManagerAndRepositoryTest
{
    public function setUp()
    {
        $this->findAllReturnValue = [new PageManager(), new PageManager()];
        parent::setUp();
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage::getAll
     */
    public function testGetAll()
    {
        $pageManagerStorage = new PageManagerStorage(
            $this->entityManager,
            PageManager::class
        );
        $this->assertInternalType('array', $pageManagerStorage->getAll());
        foreach ($pageManagerStorage->getAll() as $pageManager) {
            $this->assertInstanceOf(PageManagerInterface::class, $pageManager);
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage::persist
     */
    public function testPersist()
    {
        $pageManagerStorage = new PageManagerStorage(
            $this->entityManager,
            PageManagerStorage::class
        );

        $pageManagerA = new PageManager();
        $pageManagerStorage->persist($pageManagerA);
        $this->assertContains($pageManagerA, $this->persistedEntities);
        $this->assertContains($pageManagerA, $this->persistedAndFlushedEntities);

        $pageManagerB = new PageManager();
        $pageManagerStorage->persist($pageManagerB);
        $this->assertNotContains($pageManagerA, $this->persistedEntities);
        $this->assertContains($pageManagerB, $this->persistedEntities);
        $this->assertContains($pageManagerA, $this->persistedAndFlushedEntities);
        $this->assertContains($pageManagerB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage::persistMultiple
     */
    public function testPersistMultiple()
    {
        $pageManagerStorage = new PageManagerStorage(
            $this->entityManager,
            PageManagerStorage::class
        );

        $pageManagerA = new PageManager();
        $pageManagerB = new PageManager();

        $pageManagerStorage->persistMultiple([$pageManagerA, $pageManagerB]);
        $this->assertContains($pageManagerA, $this->persistedEntities);
        $this->assertContains($pageManagerB, $this->persistedEntities);
        $this->assertContains($pageManagerA, $this->persistedAndFlushedEntities);
        $this->assertContains($pageManagerB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageManagerStorage::persistMultiple
     */
    public function testPersistMultipleException()
    {
        $pageManagerStorage = new PageManagerStorage(
            $this->entityManager,
            PageManagerStorage::class
        );

        $pageManager = new PageManager();
        $date = new \DateTimeImmutable();

        try {
            $pageManagerStorage->persistMultiple([$pageManager, $date]);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        $this->fail(sprintf(
            'Expected %s for invalid %s::persistMultiple',
            \InvalidArgumentException::class,
            PageManager::class
        ));
    }
}
