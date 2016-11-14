<?php

namespace FL\FacebookPagesBundle\Tests\Services\Facebook\V2_8;

use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageRating;
use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient;
use FL\FacebookPagesBundle\Tests\Util\Url\ManipulateUrl;
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
        new FacebookUserClient('fakeAppId', 'fakeAppSecret', PageManager::class, Page::class, PageRating::class);
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
        $facebookUserClient = new FacebookUserClient('fakeAppId', 'fakeAppSecret', PageManager::class, Page::class, PageRating::class, $ourGuzzleClient);
        $facebookUser = new PageManager();
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
        $client = new FacebookUserClient('fakeAppId', 'fakeAppSecret', PageManager::class, Page::class, PageRating::class);
        $facebookUser = new PageManager();
        $facebookUser->setLongLivedToken(null);
        $client->get('/me', $facebookUser);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient::generateAuthorizationUrl
     */
    public function testGenerateAuthorizationUrl()
    {
        $client = new FacebookUserClient('fakeAppId', 'fakeAppSecret', PageManager::class, Page::class, PageRating::class);
        $url = $client->generateAuthorizationUrl('https://www.example.com/callbackurl');

        /*
         * Keep in mind $client->generateAuthorizationUrl will return a url that has a query,
         * with a changing state parameter. E.g. ...'state=819273ab81238ba7123' or ...'state=21f371ce23bac6123'
         */
        $this->assertEquals(
            ManipulateUrl::removeParametersFromQueryInUrl($url, ['state']),
            'https://www.facebook.com/v2.8/dialog/oauth?client_id=fakeAppId'.
            '&response_type=code&sdk=php-sdk-5.4.0&redirect_uri='.
            'https%3A%2F%2Fwww.example.com%2Fcallbackurl&scope='.
            'public_profile%2Cemail%2Cmanage_pages%2Cpublish_pages%2Cpages_messaging');
    }
}
