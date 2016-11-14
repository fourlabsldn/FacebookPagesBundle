<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\PageReview;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;

class PageReviewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageReview::getCreatedAt
     * @covers \FL\FacebookPagesBundle\Model\PageReview::setCreatedAt
     * @covers \FL\FacebookPagesBundle\Model\PageReview::getReview
     * @covers \FL\FacebookPagesBundle\Model\PageReview::setReview
     * @covers \FL\FacebookPagesBundle\Model\PageReview::getText
     * @covers \FL\FacebookPagesBundle\Model\PageReview::setText
     * @covers \FL\FacebookPagesBundle\Model\PageReview::getReviewerId
     * @covers \FL\FacebookPagesBundle\Model\PageReview::setReviewerId
     */
    public function testGettersAndSetters()
    {
        $pageManager = new PageReview();
        $tool = new TestTool();

        $tool
            ->addTestItem(new TestItemImmutable('getCreatedAt', 'setCreatedAt', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getReview', 'setReview', 3))
            ->addTestItem(new TestItemImmutable('getText', 'setText', 'It was very good!'))
            ->addTestItem(new TestItemImmutable('getReviewerId', 'setReviewerId', '1234567890'))
        ;

        if (!$tool->doGettersAndSettersWork($pageManager)) {
            static::fail($tool->getLatestErrorMessage());
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageReview::getCreatedAt
     * @covers \FL\FacebookPagesBundle\Model\PageReview::getReview
     * @covers \FL\FacebookPagesBundle\Model\PageReview::getText
     * @covers \FL\FacebookPagesBundle\Model\PageReview::getReviewerId
     */
    public function testNullValuesInNewObject()
    {
        $pageReview = new PageReview();
        static::assertNull($pageReview->getCreatedAt());
        static::assertNull($pageReview->getReview());
        static::assertNull($pageReview->getText());
        static::assertNull($pageReview->getReviewerId());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageReview::hasReview
     */
    public function testHasReviewIsTrue()
    {
        $pageReview = new PageReview();
        $pageReview->setReview(2);
        static::assertTrue($pageReview->hasReview());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageReview::hasText
     */
    public function testHasTextIsTrue()
    {
        $pageReview = new PageReview();
        $pageReview->setText('Some Review!');
        static::assertTrue($pageReview->hasText());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageReview::hasReview
     */
    public function testHasReviewIsFalseIfReviewIsNull()
    {
        $pageReview = new PageReview();
        static::assertFalse($pageReview->hasReview());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageReview::hasText
     */
    public function testHasTextIsFalseInNewObject()
    {
        $pageReview = new PageReview();
        static::assertFalse($pageReview->hasText());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageReview::setReview
     */
    public function testValidSetReview()
    {
        $pageReview = new PageReview();
        $pageReview->setReview(1);
        $pageReview->setReview(2);
        $pageReview->setReview(3);
        $pageReview->setReview(4);
        $pageReview->setReview(5);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageReview::setReview
     */
    public function testInvalidSetReview()
    {
        $pageReview = new PageReview();
        $totalExceptions = 0;

        try {
            $pageReview->setReview(-10);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageReview->setReview(0);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageReview->setReview(6);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageReview->setReview(20);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }

        if ($totalExceptions !== 4) {
            static::fail(sprintf('-10, 0, 6, and 20 must throw an exception when using %s::setReview', PageReview::class));
        }
    }
}
