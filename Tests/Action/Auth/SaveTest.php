<?php

namespace FL\FacebookPagesBundle\Action;

use Facebook\Facebook;
use FL\FacebookPagesBundle\Action\Auth\Save;
use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageReview;
use FL\FacebookPagesBundle\Services\Facebook\PageManagerClient;
use FL\FacebookPagesBundle\Storage\PageStorageInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveTest extends TestCase
{
    public function testInvoke()
    {
        // We won't have a valid token, so we will get an exception.
        static::expectException(\InvalidArgumentException::class);

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
        $pageStorage = $this->getMockBuilder(PageStorageInterface::class)->getMock();
        $saveAction = new Save($pageManagerClient, $pageStorage, 'https://www.example.com');
        $this->assertInstanceOf(RedirectResponse::class, $saveAction(new Request()));
    }
}
