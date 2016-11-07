<?php

namespace FL\FacebookPagesBundle\Tests\Storage\DoctrineORM;

use FL\FacebookPagesBundle\Model\PageRating;
use FL\FacebookPagesBundle\Model\PageRatingInterface;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage;
use FL\FacebookPagesBundle\Tests\Util\Storage\DoctrineORM\ManagerAndRepositoryTest;

class PageRatingStorageTest extends ManagerAndRepositoryTest
{
    public function setUp()
    {
        $this->findAllReturnValue = [new PageRating(), new PageRating()];
        parent::setUp();
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::getAll
     */
    public function testGetAll()
    {
        $this->entityManager->clear();
        $pageRatingStorage = new PageRatingStorage(
            $this->entityManager,
            PageRatingStorage::class
        );
        $this->assertInternalType('array', $pageRatingStorage->getAll());
        foreach ($pageRatingStorage->getAll() as $rating) {
            $this->assertInstanceOf(PageRatingInterface::class, $rating);
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::persist
     */
    public function testPersist()
    {
        $pageRatingStorage = new PageRatingStorage(
            $this->entityManager,
            PageRatingStorage::class
        );

        $pageRatingA = new PageRating();
        $pageRatingStorage->persist($pageRatingA);
        $this->assertContains($pageRatingA, $this->persistedEntities);
        $this->assertContains($pageRatingA, $this->persistedAndFlushedEntities);

        $pageRatingB = new PageRating();
        $pageRatingStorage->persist($pageRatingB);
        $this->assertNotContains($pageRatingA, $this->persistedEntities);
        $this->assertContains($pageRatingB, $this->persistedEntities);
        $this->assertContains($pageRatingA, $this->persistedAndFlushedEntities);
        $this->assertContains($pageRatingB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::persistMultiple
     */
    public function testPersistMultiple()
    {
        $pageRatingStorage = new PageRatingStorage(
            $this->entityManager,
            PageRatingStorage::class
        );

        $pageRatingA = new PageRating();
        $pageRatingB = new PageRating();

        $pageRatingStorage->persistMultiple([$pageRatingA, $pageRatingB]);
        $this->assertContains($pageRatingA, $this->persistedEntities);
        $this->assertContains($pageRatingB, $this->persistedEntities);
        $this->assertContains($pageRatingA, $this->persistedAndFlushedEntities);
        $this->assertContains($pageRatingB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::persistMultiple
     */
    public function testPersistMultipleException()
    {
        $pageRatingStorage = new PageRatingStorage(
            $this->entityManager,
            PageRatingStorage::class
        );

        $pageRating = new PageRating();
        $date = new \DateTimeImmutable();

        try {
            $pageRatingStorage->persistMultiple([$pageRating, $date]);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        $this->fail(sprintf(
            'Expected %s for invalid %s::persistMultiple',
            \InvalidArgumentException::class,
            PageRating::class
        ));
    }
}
