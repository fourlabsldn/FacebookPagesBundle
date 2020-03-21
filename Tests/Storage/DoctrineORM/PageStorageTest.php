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

    public function testGetAll()
    {
        $this->entityManager->clear();
        $pageStorage = new PageStorage(
            $this->entityManager,
            PageStorage::class
        );
        static::assertInternalType('array', $pageStorage->getAll());
        foreach ($pageStorage->getAll() as $page) {
            static::assertInstanceOf(PageInterface::class, $page);
        }
    }

    public function testPersist()
    {
        $pageStorage = new PageStorage(
            $this->entityManager,
            PageStorage::class
        );

        $pageA = new Page();
        $pageStorage->persist($pageA);
        static::assertContains($pageA, $this->persistedEntities);
        static::assertContains($pageA, $this->persistedAndFlushedEntities);

        $pageB = new Page();
        $pageStorage->persist($pageB);
        static::assertNotContains($pageA, $this->persistedEntities);
        static::assertContains($pageB, $this->persistedEntities);
        static::assertContains($pageA, $this->persistedAndFlushedEntities);
        static::assertContains($pageB, $this->persistedAndFlushedEntities);
    }

    public function testPersistMultiple()
    {
        $pageStorage = new PageStorage(
            $this->entityManager,
            PageStorage::class
        );

        $pageA = new Page();
        $pageB = new Page();

        $pageStorage->persistMultiple([$pageA, $pageB]);
        static::assertContains($pageA, $this->persistedEntities);
        static::assertContains($pageB, $this->persistedEntities);
        static::assertContains($pageA, $this->persistedAndFlushedEntities);
        static::assertContains($pageB, $this->persistedAndFlushedEntities);
    }

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

        static::fail(sprintf(
            'Expected %s for invalid %s::persistMultiple',
            \InvalidArgumentException::class,
            Page::class
        ));
    }
}
