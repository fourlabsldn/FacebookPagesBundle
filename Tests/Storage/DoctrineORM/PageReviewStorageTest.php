<?php

namespace FL\FacebookPagesBundle\Tests\Storage\DoctrineORM;

use FL\FacebookPagesBundle\Model\PageReview;
use FL\FacebookPagesBundle\Model\PageReviewInterface;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageReviewStorage;
use FL\FacebookPagesBundle\Tests\Util\Storage\DoctrineORM\ManagerAndRepositoryTest;

class PageReviewStorageTest extends ManagerAndRepositoryTest
{
    public function setUp()
    {
        $this->findAllReturnValue = [new PageReview(), new PageReview()];
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
        $pageRatingStorage = new PageReviewStorage(
            $this->entityManager,
            PageReview::class
        );
        static::assertInternalType('array', $pageRatingStorage->getAll());
        foreach ($pageRatingStorage->getAll() as $rating) {
            static::assertInstanceOf(PageReviewInterface::class, $rating);
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::persist
     */
    public function testPersist()
    {
        $pageRatingStorage = new PageReviewStorage(
            $this->entityManager,
            PageReview::class
        );

        $pageRatingA = new PageReview();
        $pageRatingStorage->persist($pageRatingA);
        static::assertContains($pageRatingA, $this->persistedEntities);
        static::assertContains($pageRatingA, $this->persistedAndFlushedEntities);

        $pageRatingB = new PageReview();
        $pageRatingStorage->persist($pageRatingB);
        static::assertNotContains($pageRatingA, $this->persistedEntities);
        static::assertContains($pageRatingB, $this->persistedEntities);
        static::assertContains($pageRatingA, $this->persistedAndFlushedEntities);
        static::assertContains($pageRatingB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::__construct
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::persistMultiple
     */
    public function testPersistMultiple()
    {
        $pageRatingStorage = new PageReviewStorage(
            $this->entityManager,
            PageReview::class
        );

        $pageRatingA = new PageReview();
        $pageRatingB = new PageReview();

        $pageRatingStorage->persistMultiple([$pageRatingA, $pageRatingB]);
        static::assertContains($pageRatingA, $this->persistedEntities);
        static::assertContains($pageRatingB, $this->persistedEntities);
        static::assertContains($pageRatingA, $this->persistedAndFlushedEntities);
        static::assertContains($pageRatingB, $this->persistedAndFlushedEntities);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage::persistMultiple
     */
    public function testPersistMultipleException()
    {
        $pageRatingStorage = new PageReviewStorage(
            $this->entityManager,
            PageReview::class
        );

        $pageRating = new PageReview();
        $date = new \DateTimeImmutable();

        try {
            $pageRatingStorage->persistMultiple([$pageRating, $date]);
        } catch (\InvalidArgumentException $exception) {
            return;
        }

        static::fail(sprintf(
            'Expected %s for invalid %s::persistMultiple',
            \InvalidArgumentException::class,
            PageReview::class
        ));
    }
}
