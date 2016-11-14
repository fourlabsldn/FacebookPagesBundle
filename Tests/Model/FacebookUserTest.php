<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;

class FacebookUserTest extends \PHPUnit_Framework_TestCase
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
        $facebookUser = new PageManager();
        $tool = new TestTool();

        $tool
            ->addTestItem(new TestItemImmutable('getShortLivedToken', 'setShortLivedToken', '{some_token_8172361}'))
            ->addTestItem(new TestItemImmutable('getShortLivedTokenExpiration', 'setShortLivedTokenExpiration', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getLongLivedToken', 'setLongLivedToken', '{some_token_8172361}'))
            ->addTestItem(new TestItemImmutable('getLongLivedTokenExpiration', 'setLongLivedTokenExpiration', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getUserId', 'setUserId', '123812479124791287192412312412371924871924'))
        ;

        if (!$tool->doGettersAndSettersWork($facebookUser)) {
            $this->fail($tool->getLatestErrorMessage());
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
        $facebookUser = new PageManager();
        $this->assertNull($facebookUser->getLongLivedToken());
        $this->assertNull($facebookUser->getLongLivedTokenExpiration());
        $this->assertNull($facebookUser->getShortLivedToken());
        $this->assertNull($facebookUser->getShortLivedTokenExpiration());
        $this->assertNull($facebookUser->getUserId());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfTokenNull()
    {
        $facebookUser = new PageManager();
        $this->assertTrue($facebookUser->isLongLivedTokenExpired());
        $facebookUser->setLongLivedToken(null);
        $this->assertTrue($facebookUser->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfPastToken()
    {
        $facebookUser = new PageManager();
        $now = new \DateTimeImmutable('now');
        $facebookUser->setLongLivedToken('{token}');
        $facebookUser->setLongLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        $this->assertTrue($facebookUser->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfFutureToken()
    {
        $facebookUser = new PageManager();
        $now = new \DateTimeImmutable('now');
        $facebookUser->setLongLivedToken('{token}');
        $facebookUser->setLongLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        $this->assertFalse($facebookUser->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isShortLivedTokenExpired()
     */
    public function testShortLivedExpirationIfTokenNull()
    {
        $facebookUser = new PageManager();
        $this->assertTrue($facebookUser->isShortLivedTokenExpired());
        $facebookUser->setShortLivedToken(null);
        $this->assertTrue($facebookUser->isShortLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isShortLivedTokenExpired
     */
    public function testShortLivedExpirationIfPastToken()
    {
        $facebookUser = new PageManager();
        $now = new \DateTimeImmutable('now');
        $facebookUser->setShortLivedToken('{token}');
        $facebookUser->setShortLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        $this->assertTrue($facebookUser->isShortLivedTokenExpired());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Model\PageManager::isShortLivedTokenExpired
     */
    public function testShortLivedExpirationIfFutureToken()
    {
        $facebookUser = new PageManager();
        $now = new \DateTimeImmutable('now');
        $facebookUser->setShortLivedToken('{token}');
        $facebookUser->setShortLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        $this->assertFalse($facebookUser->isShortLivedTokenExpired());
    }
}
