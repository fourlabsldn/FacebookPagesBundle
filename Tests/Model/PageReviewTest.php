<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\PageReview;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;

class PageReviewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::getCreatedAt
     * @covers \FL\FacebookPagesBundle\Model\PageRating::setCreatedAt
     * @covers \FL\FacebookPagesBundle\Model\PageRating::getRating
     * @covers \FL\FacebookPagesBundle\Model\PageRating::setRating
     * @covers \FL\FacebookPagesBundle\Model\PageRating::getReview
     * @covers \FL\FacebookPagesBundle\Model\PageRating::setReview
     * @covers \FL\FacebookPagesBundle\Model\PageRating::getReviewerId
     * @covers \FL\FacebookPagesBundle\Model\PageRating::setReviewerId
     */
    public function testGettersAndSetters()
    {
        $pageManager = new PageReview();
        $tool = new TestTool();

        $tool
            ->addTestItem(new TestItemImmutable('getCreatedAt', 'setCreatedAt', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getRating', 'setRating', 3))
            ->addTestItem(new TestItemImmutable('getReview', 'setReview', 'It was very good!'))
            ->addTestItem(new TestItemImmutable('getReviewerId', 'setReviewerId', '1234567890'))
        ;

        if (!$tool->doGettersAndSettersWork($pageManager)) {
            static::fail($tool->getLatestErrorMessage());
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::getCreatedAt
     * @covers \FL\FacebookPagesBundle\Model\PageRating::getRating
     * @covers \FL\FacebookPagesBundle\Model\PageRating::getReview
     * @covers \FL\FacebookPagesBundle\Model\PageRating::getReviewerId
     */
    public function testNullValuesInNewObject()
    {
        $pageRating = new PageReview();
        static::assertNull($pageRating->getCreatedAt());
        static::assertNull($pageRating->getRating());
        static::assertNull($pageRating->getText());
        static::assertNull($pageRating->getReviewerId());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::hasRating
     */
    public function testHasRatingIsTrue()
    {
        $pageRating = new PageReview();
        $pageRating->setRating(2);
        static::assertTrue($pageRating->hasRating());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::hasReview
     */
    public function testHasReviewIsTrue()
    {
        $pageRating = new PageReview();
        $pageRating->setText('Some Review!');
        static::assertTrue($pageRating->hasText());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::hasRating
     */
    public function testHasRatingIsFalseIfRatingIsNull()
    {
        $pageRating = new PageReview();
        static::assertFalse($pageRating->hasRating());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::hasReview
     */
    public function testHasReviewIsFalseInNewObject()
    {
        $pageRating = new PageReview();
        static::assertFalse($pageRating->hasText());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::setRating
     */
    public function testValidSetRating()
    {
        $pageRating = new PageReview();
        $pageRating->setRating(1);
        $pageRating->setRating(2);
        $pageRating->setRating(3);
        $pageRating->setRating(4);
        $pageRating->setRating(5);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::setRating
     */
    public function testInvalidSetRating()
    {
        $pageRating = new PageReview();
        $totalExceptions = 0;

        try {
            $pageRating->setRating(-10);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageRating->setRating(0);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageRating->setRating(6);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageRating->setRating(20);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }

        if ($totalExceptions !== 4) {
            static::fail(sprintf('-10, 0, 6, and 20 must throw an exception when using %s::setRating', PageReview::class));
        }
    }
}
