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

    public function testGetAll()
    {
        $pageManagerStorage = new PageManagerStorage(
            $this->entityManager,
            PageManager::class
        );
        static::assertInternalType('array', $pageManagerStorage->getAll());
        foreach ($pageManagerStorage->getAll() as $pageManager) {
            static::assertInstanceOf(PageManagerInterface::class, $pageManager);
        }
    }

    public function testPersist()
    {
        $pageManagerStorage = new PageManagerStorage(
            $this->entityManager,
            PageManagerStorage::class
        );

        $pageManagerA = new PageManager();
        $pageManagerStorage->persist($pageManagerA);
        static::assertContains($pageManagerA, $this->persistedEntities);
        static::assertContains($pageManagerA, $this->persistedAndFlushedEntities);

        $pageManagerB = new PageManager();
        $pageManagerStorage->persist($pageManagerB);
        static::assertNotContains($pageManagerA, $this->persistedEntities);
        static::assertContains($pageManagerB, $this->persistedEntities);
        static::assertContains($pageManagerA, $this->persistedAndFlushedEntities);
        static::assertContains($pageManagerB, $this->persistedAndFlushedEntities);
    }

    public function testPersistMultiple()
    {
        $pageManagerStorage = new PageManagerStorage(
            $this->entityManager,
            PageManagerStorage::class
        );

        $pageManagerA = new PageManager();
        $pageManagerB = new PageManager();

        $pageManagerStorage->persistMultiple([$pageManagerA, $pageManagerB]);
        static::assertContains($pageManagerA, $this->persistedEntities);
        static::assertContains($pageManagerB, $this->persistedEntities);
        static::assertContains($pageManagerA, $this->persistedAndFlushedEntities);
        static::assertContains($pageManagerB, $this->persistedAndFlushedEntities);
    }

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

        static::fail(sprintf(
            'Expected %s for invalid %s::persistMultiple',
            \InvalidArgumentException::class,
            PageManager::class
        ));
    }
}
