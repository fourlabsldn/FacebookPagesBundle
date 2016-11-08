<?php

namespace FL\FacebookPagesBundle\Action;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use FL\FacebookPagesBundle\Storage\FacebookUserStorageInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class SaveAuthorizationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Action\SaveAuthorization::__construct
     * @covers \FL\FacebookPagesBundle\Action\SaveAuthorization::__invoke
     */
    public function testInvoke()
    {
        $facebookUserClient = new FacebookUserClient('fakeAppId', 'fakeAppSecret');
        $storage = $this->getMockBuilder(FacebookUserStorageInterface::class)->getMock();
        $saveAction = new SaveAuthorization($facebookUserClient, $storage);
        $this->assertInstanceOf(Response::class, $saveAction(new Request()));
    }
}
