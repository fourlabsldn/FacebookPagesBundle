<?php

namespace FL\FacebookPagesBundle\Tests\Guzzle;

use FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;

/**
 * @link https://github.com/guzzle/guzzle/blob/master/docs/testing.rst
 */
class Guzzle6HttpClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient::__construct
     */
    public function testConstruct()
    {
        new Guzzle6HttpClient(new Client());
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient::send
     */
    public function testSend()
    {
        $stack = HandlerStack::create(new MockHandler([
            new Response(200, ['FakeResponseHeader' => 'FakeValue']),
        ]));
        $container = [];
        $stack->push(Middleware::history($container));
        $ourClient = new Guzzle6HttpClient(new Client([
            'handler' => $stack,
        ]));
        $ourClient->send('http://www.notactuallyrequested.com', 'GET', '', [], 0);

        /** @var Request $request */
        $request = $container[0]['request'];
        $this->assertEquals($request->getUri()->getScheme(), 'http');
        $this->assertEquals($request->getUri()->getHost(), 'www.notactuallyrequested.com');
        $this->assertEquals($request->getUri()->getPath(), '');
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient::send
     * @expectedException \Facebook\Exceptions\FacebookSDKException
     */
    public function testSendException()
    {
        $mockHandler = new MockHandler(
            [new Response(200)],
            function () {
                throw new RequestException('Exception!', new Request('GET', 'http://www.notactuallyrequested.com'));
            }
        );
        $stack = HandlerStack::create($mockHandler);
        $container = [];
        $stack->push(Middleware::history($container));
        $ourClient = new Guzzle6HttpClient(new Client([
            'handler' => $stack,
        ]));
        $ourClient->send('http://www.notactuallyrequested.com', 'GET', '', [], 0);
    }
}
