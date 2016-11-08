<?php

namespace FL\FacebookPagesBundle\Tests\Services\Facebook\V2_8;

use FL\FacebookPagesBundle\Model\FacebookUser;
use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

/**
 * @link https://github.com/guzzle/guzzle/blob/master/docs/testing.rst
 */
class FacebookUserClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient::__construct
     */
    public function testConstruction()
    {
        new FacebookUserClient('fakeAppId', 'fakeAppToken');
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient::get
     */
    public function testGetWithToken()
    {
        $stack = HandlerStack::create(new MockHandler([
            new Response(200, ['FakeResponseHeader' => 'FakeValue']),
        ]));
        $container = [];
        $stack->push(Middleware::history($container));
        $ourGuzzleClient = new Guzzle6HttpClient(new Client([
            'handler' => $stack,
        ]));
        $facebookUserClient = new FacebookUserClient('fakeAppId', 'fakeAppToken', $ourGuzzleClient);
        $facebookUser = new FacebookUser();
        $facebookUser->setLongLivedToken('someToken12371623123812763');
        $facebookUserClient->get('/me', $facebookUser);

        /** @var Request $request */
        $request = $container[0]['request'];
        $this->assertEquals($request->getUri()->getScheme(), 'https');
        $this->assertEquals($request->getUri()->getHost(), 'graph.facebook.com');
        $this->assertEquals($request->getUri()->getPath(), '/v2.8/me');
        $this->assertContains('someToken12371623123812763', $request->getUri()->getQuery());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient::get
     * @expectedException \InvalidArgumentException
     */
    public function testGetException()
    {
        $client = new FacebookUserClient('fakeAppId', 'fakeAppToken');
        $facebookUser = new FacebookUser();
        $facebookUser->setLongLivedToken(null);
        $client->get('/me', $facebookUser);
    }
}
