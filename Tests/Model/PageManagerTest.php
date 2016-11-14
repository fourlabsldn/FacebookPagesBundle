<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;

class PageManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getShortLivedToken
     * @covers \FL\FacebookPagesBundle\Model\PageManager::setShortLivedToken
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getShortLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\PageManager::setShortLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getLongLivedToken
     * @covers \FL\FacebookPagesBundle\Model\PageManager::setLongLivedToken
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getLongLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\PageManager::setLongLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getUserId
     * @covers \FL\FacebookPagesBundle\Model\PageManager::setUserId
     */
    public function testGettersAndSetters()
    {
        $pageManager = new PageManager();
        $tool = new TestTool();

        $tool
            ->addTestItem(new TestItemImmutable('getShortLivedToken', 'setShortLivedToken', '{some_token_8172361}'))
            ->addTestItem(new TestItemImmutable('getShortLivedTokenExpiration', 'setShortLivedTokenExpiration', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getLongLivedToken', 'setLongLivedToken', '{some_token_8172361}'))
            ->addTestItem(new TestItemImmutable('getLongLivedTokenExpiration', 'setLongLivedTokenExpiration', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getUserId', 'setUserId', '123812479124791287192412312412371924871924'))
        ;

        if (!$tool->doGettersAndSettersWork($pageManager)) {
            static::fail($tool->getLatestErrorMessage());
        }
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getShortLivedToken
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getShortLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getLongLivedToken
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getLongLivedTokenExpiration
     * @covers \FL\FacebookPagesBundle\Model\PageManager::getUserId
     */
    public function testNullValuesInNewObject()
    {
        $pageManager = new PageManager();
        static::assertNull($pageManager->getLongLivedToken());
        static::assertNull($pageManager->getLongLivedTokenExpiration());
        static::assertNull($pageManager->getShortLivedToken());
        static::assertNull($pageManager->getShortLivedTokenExpiration());
        static::assertNull($pageManager->getUserId());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfTokenNull()
    {
        $pageManager = new PageManager();
        static::assertTrue($pageManager->isLongLivedTokenExpired());
        $pageManager->setLongLivedToken(null);
        static::assertTrue($pageManager->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfPastToken()
    {
        $pageManager = new PageManager();
        $now = new \DateTimeImmutable('now');
        $pageManager->setLongLivedToken('{token}');
        $pageManager->setLongLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        static::assertTrue($pageManager->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfFutureToken()
    {
        $pageManager = new PageManager();
        $now = new \DateTimeImmutable('now');
        $pageManager->setLongLivedToken('{token}');
        $pageManager->setLongLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        static::assertFalse($pageManager->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isShortLivedTokenExpired()
     */
    public function testShortLivedExpirationIfTokenNull()
    {
        $pageManager = new PageManager();
        static::assertTrue($pageManager->isShortLivedTokenExpired());
        $pageManager->setShortLivedToken(null);
        static::assertTrue($pageManager->isShortLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isShortLivedTokenExpired
     */
    public function testShortLivedExpirationIfPastToken()
    {
        $pageManager = new PageManager();
        $now = new \DateTimeImmutable('now');
        $pageManager->setShortLivedToken('{token}');
        $pageManager->setShortLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        static::assertTrue($pageManager->isShortLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isShortLivedTokenExpired
     */
    public function testShortLivedExpirationIfFutureToken()
    {
        $pageManager = new PageManager();
        $now = new \DateTimeImmutable('now');
        $pageManager->setShortLivedToken('{token}');
        $pageManager->setShortLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        static::assertFalse($pageManager->isShortLivedTokenExpired());
    }
}
