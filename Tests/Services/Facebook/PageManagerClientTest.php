<?php

namespace FL\FacebookPagesBundle\Tests\Services\Facebook;

use Facebook\Facebook;
use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageReview;
use FL\FacebookPagesBundle\Services\Facebook\PageManagerClient;
use FL\FacebookPagesBundle\Guzzle\Guzzle6HttpClient;
use FL\FacebookPagesBundle\Tests\Util\Url\ManipulateUrl;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

/**
 * @link https://github.com/guzzle/guzzle/blob/master/docs/testing.rst
 */
class PageManagerClientTest extends TestCase
{
    public function testConstruction()
    {
        new PageManagerClient(
            'fakeAppId',
            PageManager::class,
            Page::class,
            PageReview::class,
            new Facebook([
                'app_id' => 'fakeAppId',
                'app_secret' => 'faceAppSecret',
                'default_graph_version' => 'v3.1',
            ])
        );
    }

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
        $pageManagerClient = new PageManagerClient(
            'fakeAppId',
            PageManager::class,
            Page::class,
            PageReview::class,
            new Facebook([
                'app_id' => 'fakeAppId',
                'app_secret' => 'faceAppSecret',
                'default_graph_version' => 'v3.1',
                'http_client_handler' => $ourGuzzleClient,
            ])
        );
        $pageManager = new PageManager();
        $pageManager->setLongLivedToken('someToken12371623123812763');
        $pageManagerClient->get('/me', $pageManager);

        /** @var Request $request */
        $request = $container[0]['request'];
        static::assertEquals($request->getUri()->getScheme(), 'https');
        static::assertEquals($request->getUri()->getHost(), 'graph.facebook.com');
        static::assertEquals($request->getUri()->getPath(), '/v3.1/me');
        static::assertContains('someToken12371623123812763', $request->getUri()->getQuery());
    }

    public function testGetException()
    {
        static::expectException(\InvalidArgumentException::class);

        $client = new PageManagerClient(
            'fakeAppId',
            PageManager::class,
            Page::class,
            PageReview::class,
            new Facebook([
                'app_id' => 'fakeAppId',
                'app_secret' => 'faceAppSecret',
                'default_graph_version' => 'v3.1',
            ])
        );
        $pageManager = new PageManager();
        $pageManager->setLongLivedToken(null);
        $client->get('/me', $pageManager);
    }

    public function testGenerateAuthorizationUrl()
    {
        $client = new PageManagerClient(
            'fakeAppId',
            PageManager::class,
            Page::class,
            PageReview::class,
            new Facebook([
                'app_id' => 'fakeAppId',
                'app_secret' => 'faceAppSecret',
                'default_graph_version' => 'v3.1',
            ])
        );
        $url = $client->generateAuthorizationUrl('https://www.example.com/callbackurl');

        /*
         * Keep in mind $client->generateAuthorizationUrl will return a url that has a query,
         * with a changing state parameter. E.g. ...'state=819273ab81238ba7123' or ...'state=21f371ce23bac6123'
         */
        static::assertEquals(
            ManipulateUrl::removeParametersFromQueryInUrl($url, ['state']),
            'https://www.facebook.com/v3.1/dialog/oauth?client_id=fakeAppId'.
            '&response_type=code&sdk=php-sdk-6.0-dev&redirect_uri='.
            'https%3A%2F%2Fwww.example.com%2Fcallbackurl&scope=manage_pages');
    }
}
