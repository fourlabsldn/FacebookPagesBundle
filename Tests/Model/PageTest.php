<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;
use PHPUnit\Framework\TestCase;

class PageTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $page = new Page();
        $tool = new TestTool();

        $tool
            ->addTestItem(new TestItemImmutable('getShortLivedToken', 'setShortLivedToken', '{some_token_8172361}'))
            ->addTestItem(new TestItemImmutable('getShortLivedTokenExpiration', 'setShortLivedTokenExpiration', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getLongLivedToken', 'setLongLivedToken', '{some_token_8172361}'))
            ->addTestItem(new TestItemImmutable('getLongLivedTokenExpiration', 'setLongLivedTokenExpiration', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getPageId', 'setPageId', '123812479124791287192412312412371924871924'))
            ->addTestItem(new TestItemImmutable('getCategory', 'setCategory', 'SomeParentCategory/Category'))
        ;

        if (!$tool->doGettersAndSettersWork($page)) {
            static::fail($tool->getLatestErrorMessage());
        }
    }

    public function testNullValuesInNewObject()
    {
        $page = new Page();
        static::assertNull($page->getLongLivedToken());
        static::assertNull($page->getLongLivedTokenExpiration());
        static::assertNull($page->getShortLivedToken());
        static::assertNull($page->getShortLivedTokenExpiration());
        static::assertNull($page->getPageId());
        static::assertNull($page->getCategory());
    }

    public function testLongLivedExpirationIfTokenNull()
    {
        $page = new Page();
        static::assertTrue($page->isLongLivedTokenExpired());
        $page->setLongLivedToken(null);
        static::assertTrue($page->isLongLivedTokenExpired());
    }

    public function testLongLivedExpirationIfPastToken()
    {
        $page = new Page();
        $now = new \DateTimeImmutable('now');
        $page->setLongLivedToken('{token}');
        $page->setLongLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        static::assertTrue($page->isLongLivedTokenExpired());
    }

    public function testLongLivedExpirationIfFutureToken()
    {
        $page = new Page();
        $now = new \DateTimeImmutable('now');
        $page->setLongLivedToken('{token}');
        $page->setLongLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        static::assertFalse($page->isLongLivedTokenExpired());
    }

    public function testShortLivedExpirationIfTokenNull()
    {
        $page = new Page();
        static::assertTrue($page->isShortLivedTokenExpired());
        $page->setShortLivedToken(null);
        static::assertTrue($page->isShortLivedTokenExpired());
    }

    public function testShortLivedExpirationIfPastToken()
    {
        $page = new Page();
        $now = new \DateTimeImmutable('now');
        $page->setShortLivedToken('{token}');
        $page->setShortLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        static::assertTrue($page->isShortLivedTokenExpired());
    }

    public function testShortLivedExpirationIfFutureToken()
    {
        $page = new Page();
        $now = new \DateTimeImmutable('now');
        $page->setShortLivedToken('{token}');
        $page->setShortLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        static::assertFalse($page->isShortLivedTokenExpired());
    }
}
