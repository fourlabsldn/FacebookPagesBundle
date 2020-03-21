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

    public function testGetAll()
    {
        $this->entityManager->clear();
        $pageReviewStorage = new PageReviewStorage(
            $this->entityManager,
            PageReview::class
        );
        static::assertInternalType('array', $pageReviewStorage->getAll());
        foreach ($pageReviewStorage->getAll() as $review) {
            static::assertInstanceOf(PageReviewInterface::class, $review);
        }
    }

    public function testPersist()
    {
        $pageReviewStorage = new PageReviewStorage(
            $this->entityManager,
            PageReview::class
        );

        $pageReviewA = new PageReview();
        $pageReviewStorage->persist($pageReviewA);
        static::assertContains($pageReviewA, $this->persistedEntities);
        static::assertContains($pageReviewA, $this->persistedAndFlushedEntities);

        $pageReviewB = new PageReview();
        $pageReviewStorage->persist($pageReviewB);
        static::assertNotContains($pageReviewA, $this->persistedEntities);
        static::assertContains($pageReviewB, $this->persistedEntities);
        static::assertContains($pageReviewA, $this->persistedAndFlushedEntities);
        static::assertContains($pageReviewB, $this->persistedAndFlushedEntities);
    }

    public function testPersistMultiple()
    {
        $pageReviewStorage = new PageReviewStorage(
            $this->entityManager,
            PageReview::class
        );

        $pageReviewA = new PageReview();
        $pageReviewB = new PageReview();

        $pageReviewStorage->persistMultiple([$pageReviewA, $pageReviewB]);
        static::assertContains($pageReviewA, $this->persistedEntities);
        static::assertContains($pageReviewB, $this->persistedEntities);
        static::assertContains($pageReviewA, $this->persistedAndFlushedEntities);
        static::assertContains($pageReviewB, $this->persistedAndFlushedEntities);
    }

    public function testPersistMultipleException()
    {
        $pageReviewStorage = new PageReviewStorage(
            $this->entityManager,
            PageReview::class
        );

        $pageReview = new PageReview();
        $date = new \DateTimeImmutable();

        try {
            $pageReviewStorage->persistMultiple([$pageReview, $date]);
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
