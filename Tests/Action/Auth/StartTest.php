<?php

namespace FL\FacebookPagesBundle\Action;

use Facebook\Facebook;
use FL\FacebookPagesBundle\Action\Auth\Start;
use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageReview;
use FL\FacebookPagesBundle\Services\Facebook\PageManagerClient;
use FL\FacebookPagesBundle\Tests\Util\Url\ManipulateUrl;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

class StartTest extends TestCase
{
    public function testInvoke()
    {
        $pageManagerClient = new PageManagerClient(
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
        $router = $this
            ->getMockBuilder(RouterInterface::class)
            ->setMethods(['generate', 'getContext', 'match', 'getRouteCollection', 'setContext'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $router
            ->expects(static::any())
            ->method('generate')
            ->will(static::returnValue('https://www.example.com/callbackurl'))
        ;
        $authorizeAction = new Start($pageManagerClient, $router);

        /** @var RedirectResponse $response */
        $response = $authorizeAction(new Request());

        /*
         * Keep in mind $client->generateAuthorizationUrl will return a url that has a query,
         * with a changing state parameter. E.g. ...'state=819273ab81238ba7123' or ...'state=21f371ce23bac6123'
         */
        static::assertEquals(
            ManipulateUrl::removeParametersFromQueryInUrl($response->getTargetUrl(), ['state']),
            'https://www.facebook.com/v3.1/dialog/oauth?client_id=fakeAppId'.
            '&response_type=code&sdk=php-sdk-6.0-dev&redirect_uri='.
            'https%3A%2F%2Fwww.example.com%2Fcallbackurl&scope=manage_pages');
    }
}
