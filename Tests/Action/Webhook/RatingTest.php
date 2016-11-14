<?php

namespace FL\FacebookPagesBundle\Tests\Action\Webhook;

use FL\FacebookPagesBundle\Action\Webhook\Rating;
use FL\FacebookPagesBundle\Storage\PageReviewStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReviewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Action\Webhook\Rating::__construct
     * @covers \FL\FacebookPagesBundle\Action\Webhook\Rating::__invoke
     */
    public function testInvoke()
    {
        $mockRatingStorage = $this
            ->getMockBuilder(PageReviewStorageInterface::class)
            ->getMock()
        ;
        $action = new Rating($mockRatingStorage);
        /** @var Response $response */
        $response = $action(new Request());
        static::assertEquals($response->getStatusCode(), Response::HTTP_ACCEPTED);
    }
}
