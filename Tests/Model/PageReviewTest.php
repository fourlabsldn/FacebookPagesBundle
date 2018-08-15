<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\PageReview;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;
use PHPUnit\Framework\TestCase;

class PageReviewTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $pageManager = new PageReview();
        $tool = new TestTool();

        $tool
            ->addTestItem(new TestItemImmutable('getCreatedAt', 'setCreatedAt', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getRating', 'setRating', 3))
            ->addTestItem(new TestItemImmutable('getText', 'setText', 'It was very good!'))
            ->addTestItem(new TestItemImmutable('getReviewerId', 'setReviewerId', '1234567890'))
        ;

        if (!$tool->doGettersAndSettersWork($pageManager)) {
            static::fail($tool->getLatestErrorMessage());
        }
    }

    public function testNullValuesInNewObject()
    {
        $pageReview = new PageReview();
        static::assertNull($pageReview->getCreatedAt());
        static::assertNull($pageReview->getRating());
        static::assertNull($pageReview->getText());
        static::assertNull($pageReview->getReviewerId());
    }

    public function testHasRatingIsTrue()
    {
        $pageReview = new PageReview();
        $pageReview->setRating(2);
        static::assertTrue($pageReview->hasRating());
    }

    public function testHasTextIsTrue()
    {
        $pageReview = new PageReview();
        $pageReview->setText('Some Review!');
        static::assertTrue($pageReview->hasText());
    }

    public function testHasRatingIsFalseIfReviewIsNull()
    {
        $pageReview = new PageReview();
        static::assertFalse($pageReview->hasRating());
    }

    public function testHasTextIsFalseInNewObject()
    {
        $pageReview = new PageReview();
        static::assertFalse($pageReview->hasText());
    }

    public function testValidSetReview()
    {
        $pageReview = new PageReview();
        $pageReview->setRating(1);
        $pageReview->setRating(2);
        $pageReview->setRating(3);
        $pageReview->setRating(4);
        $pageReview->setRating(5);
    }

    public function testInvalidSetReview()
    {
        $pageReview = new PageReview();
        $totalExceptions = 0;

        try {
            $pageReview->setRating(-10);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageReview->setRating(0);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageReview->setRating(6);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }
        try {
            $pageReview->setRating(20);
        } catch (\InvalidArgumentException $exception) {
            ++$totalExceptions;
        }

        static::assertEquals(
            4,
            $totalExceptions,
            sprintf('-10, 0, 6, and 20 must throw an exception when using %s::setRating', PageReview::class)
        );
    }
}
