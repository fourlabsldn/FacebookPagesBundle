<?php

namespace FL\FacebookPagesBundle\Action;

use FL\FacebookPagesBundle\Action\Auth\Save;
use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageRating;
use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use FL\FacebookPagesBundle\Storage\PageManagerStorageInterface;
use FL\FacebookPagesBundle\Storage\PageStorageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class SaveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Action\SaveAuthorization::__construct
     * @covers \FL\FacebookPagesBundle\Action\SaveAuthorization::__invoke
     *
     * @expectedException \InvalidArgumentException
     * We won't have a valid token, so we will get an exception.
     */
    public function testInvoke()
    {
        $facebookUserClient = new FacebookUserClient('fakeAppId', 'fakeAppSecret', PageManager::class, Page::class, PageRating::class);
        $userStorage = $this->getMockBuilder(PageManagerStorageInterface::class)->getMock();
        $pageStorage = $this->getMockBuilder(PageStorageInterface::class)->getMock();
        $saveAction = new Save($facebookUserClient, $userStorage, $pageStorage, 'https://www.example.com');
        $this->assertInstanceOf(RedirectResponse::class, $saveAction(new Request()));
    }
}
