<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\PageRating;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;

class PageRatingTest extends \PHPUnit_Framework_TestCase
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
        $facebookUser = new PageRating();
        $tool = new TestTool();

        $tool
            ->addTestItem(new TestItemImmutable('getCreatedAt', 'setCreatedAt', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getRating', 'setRating', 3))
            ->addTestItem(new TestItemImmutable('getReview', 'setReview', 'It was very good!'))
            ->addTestItem(new TestItemImmutable('getReviewerId', 'setReviewerId', '1234567890'))
        ;

        if (!$tool->doGettersAndSettersWork($facebookUser)) {
            $this->fail($tool->getLatestErrorMessage());
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
        $pageRating = new PageRating();
        $this->assertNull($pageRating->getCreatedAt());
        $this->assertNull($pageRating->getRating());
        $this->assertNull($pageRating->getReview());
        $this->assertNull($pageRating->getReviewerId());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::hasRating
     */
    public function testHasRatingIsFalseIfRatingIsNull()
    {
        $pageRating = new PageRating();
        $this->assertFalse($pageRating->hasRating());
        $pageRating->setRating(null);
        $this->assertFalse($pageRating->hasRating());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::hasReview

     */
    public function testHasReviewIsFalseInNewObject()
    {
        $pageRating = new PageRating();
        $this->assertFalse($pageRating->hasReview());
        $pageRating->setReview(null);
        $this->assertFalse($pageRating->hasReview());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageRating::setRating
     */
    public function testValidSetRating()
    {
        $pageRating = new PageRating();
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
        $pageRating = new PageRating();
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
            $this->fail(sprintf('-10, 0, 6, and 20 must throw an exception when using %s::setRating', PageRating::class));
        }
    }
}
