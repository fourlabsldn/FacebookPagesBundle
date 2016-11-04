<?php

namespace FL\FacebookPagesBundle\Tests\Model;

use FL\FacebookPagesBundle\Model\FacebookUser;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestItemImmutable;
use FL\FacebookPagesBundle\Tests\Util\GettersSetters\TestTool;

class FacebookUserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers FacebookUser::getShortLivedToken
     * @covers FacebookUser::setShortLivedToken
     * @covers FacebookUser::getShortLivedTokenExpiration
     * @covers FacebookUser::setShortLivedTokenExpiration
     * @covers FacebookUser::getLongLivedToken
     * @covers FacebookUser::setLongLivedToken
     * @covers FacebookUser::getLongLivedTokenExpiration
     * @covers FacebookUser::setLongLivedTokenExpiration
     * @covers FacebookUser::getUserId
     * @covers FacebookUser::setUserId
     */
    public function testGettersAndSetters()
    {
        $facebookUser = new FacebookUser();
        $tool = new TestTool();

        $tool
            ->addTestItem(new TestItemImmutable('getShortLivedToken', 'setShortLivedToken', '{some_token_8172361}'))
            ->addTestItem(new TestItemImmutable('getShortLivedTokenExpiration', 'setShortLivedTokenExpiration', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getLongLivedToken', 'setLongLivedToken', '{some_token_8172361}'))
            ->addTestItem(new TestItemImmutable('getLongLivedTokenExpiration', 'setLongLivedTokenExpiration', new \DateTimeImmutable('+ 1 day + 3 hours')))
            ->addTestItem(new TestItemImmutable('getUserId', 'setUserId', '123812479124791287192412312412371924871924'))
        ;

        if (! $tool->doGettersAndSettersWork($facebookUser)) {
            $this->fail($tool->getLatestErrorMessage());
        };
    }

    /**
     * @test
     * @covers FacebookUser::getShortLivedToken
     * @covers FacebookUser::getShortLivedTokenExpiration
     * @covers FacebookUser::getLongLivedToken
     * @covers FacebookUser::getLongLivedTokenExpiration
     * @covers FacebookUser::getUserId()
     */
    public function testNullValuesInNewObject()
    {
        $facebookUser = new FacebookUser();
        $this->assertNull($facebookUser->getLongLivedToken());
        $this->assertNull($facebookUser->getLongLivedTokenExpiration());
        $this->assertNull($facebookUser->getShortLivedToken());
        $this->assertNull($facebookUser->getShortLivedTokenExpiration());
        $this->assertNull($facebookUser->getUserId());
    }

    /**
     * @test
     * @covers FacebookUser::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfTokenNull()
    {
        $facebookUser = new FacebookUser();
        $this->assertTrue($facebookUser->isLongLivedTokenExpired());
        $facebookUser->setLongLivedToken(null);
        $this->assertTrue($facebookUser->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers FacebookUser::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfPastToken()
    {
        $facebookUser = new FacebookUser();
        $now = new \DateTimeImmutable("now");
        $facebookUser->setLongLivedToken('{token}');
        $facebookUser->setLongLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        $this->assertTrue($facebookUser->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers FacebookUser::isLongLivedTokenExpired
     */
    public function testLongLivedExpirationIfFutureToken()
    {
        $facebookUser = new FacebookUser();
        $now = new \DateTimeImmutable("now");
        $facebookUser->setLongLivedToken('{token}');
        $facebookUser->setLongLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        $this->assertFalse($facebookUser->isLongLivedTokenExpired());
    }

    /**
     * @test
     * @covers FacebookUser::isShortLivedTokenExpired()
     */
    public function testShortLivedExpirationIfTokenNull()
    {
        $facebookUser = new FacebookUser();
        $this->assertTrue($facebookUser->isShortLivedTokenExpired());
        $facebookUser->setShortLivedToken(null);
        $this->assertTrue($facebookUser->isShortLivedTokenExpired());
    }

    /**
     * @test
     * @covers FacebookUser::isShortLivedTokenExpired
     */
    public function testShortLivedExpirationIfPastToken()
    {
        $facebookUser = new FacebookUser();
        $now = new \DateTimeImmutable("now");
        $facebookUser->setShortLivedToken('{token}');
        $facebookUser->setShortLivedTokenExpiration($now->sub(new \DateInterval('P1D')));
        $this->assertTrue($facebookUser->isShortLivedTokenExpired());
    }

    /**
     * @test
     * @covers FacebookUser::isShortLivedTokenExpired
     */
    public function testShortLivedExpirationIfFutureToken()
    {
        $facebookUser = new FacebookUser();
        $now = new \DateTimeImmutable("now");
        $facebookUser->setShortLivedToken('{token}');
        $facebookUser->setShortLivedTokenExpiration($now->add(new \DateInterval('P1D')));
        $this->assertFalse($facebookUser->isShortLivedTokenExpired());
    }
}