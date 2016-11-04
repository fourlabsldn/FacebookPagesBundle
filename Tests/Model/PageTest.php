<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;

class PageTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\Page::getShortLivedToken
     * @covers \FL\FacebookPagesBundle\Model\Page::setShortLivedToken
     * @covers \FL\FacebookPagesBundle\Model\Page::getShortLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\Page::setShortLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\Page::getLongLivedToken
     * @covers \FL\FacebookPagesBundle\Model\Page::setLongLivedToken
     * @covers \FL\FacebookPagesBundle\Model\Page::getLongLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\Page::setLongLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\Page::getPageId
     * @covers \FL\FacebookPagesBundle\Model\Page::setPageId
     * @covers \FL\FacebookPagesBundle\Model\Page::getCategory
     * @covers \FL\FacebookPagesBundle\Model\Page::setCategory
     */
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
            $this->fail($tool->getLatestErrorMessage());
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\Page::getShortLivedToken
     * @covers \FL\FacebookPagesBundle\Model\Page::getShortLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\Page::getLongLivedToken
     * @covers \FL\FacebookPagesBundle\Model\Page::getLongLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\Page::getPageId
     * @covers \FL\FacebookPagesBundle\Model\Page::getCategory
     */
    public function testNullValuesInNewObject()
    {
        $page = new Page();
        $this->assertNull($page->getLongLivedToken());
        $this->assertNull($page->getLongLivedTokenExpiration());
        $this->assertNull($page->getShortLivedToken());
        $this->assertNull($page->getShortLivedTokenExpiration());
        $this->assertNull($page->getPageId());
        $this->assertNull($page->getCategory());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\Page::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfTokenNull()
    {
        $page = new Page();
        $this->assertTrue($page->isLongLivedTokenExpired());
        $page->setLongLivedToken(null);
        $this->assertTrue($page->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\Page::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfPastToken()
    {
        $page = new Page();
        $now = new \DateTimeImmutable('now');
        $page->setLongLivedToken('{token}');
        $page->setLongLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        $this->assertTrue($page->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\Page::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfFutureToken()
    {
        $page = new Page();
        $now = new \DateTimeImmutable('now');
        $page->setLongLivedToken('{token}');
        $page->setLongLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        $this->assertFalse($page->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\Page::isShortLivedTokenExpired()
     */
    public function testShortLivedExpirationIfTokenNull()
    {
        $page = new Page();
        $this->assertTrue($page->isShortLivedTokenExpired());
        $page->setShortLivedToken(null);
        $this->assertTrue($page->isShortLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\Page::isShortLivedTokenExpired
     */
    public function testShortLivedExpirationIfPastToken()
    {
        $page = new Page();
        $now = new \DateTimeImmutable('now');
        $page->setShortLivedToken('{token}');
        $page->setShortLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        $this->assertTrue($page->isShortLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\Page::isShortLivedTokenExpired
     */
    public function testShortLivedExpirationIfFutureToken()
    {
        $page = new Page();
        $now = new \DateTimeImmutable('now');
        $page->setShortLivedToken('{token}');
        $page->setShortLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        $this->assertFalse($page->isShortLivedTokenExpired());
    }
}