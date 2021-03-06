<?php

namespace FL\FacebookPagesBundle\Tests\Action\Webhook;

use FL\FacebookPagesBundle\Action\Webhook\Review;
use FL\FacebookPagesBundle\Storage\PageReviewStorageInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RatingTest extends TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Action\Webhook\Review::__construct
     * @covers \FL\FacebookPagesBundle\Action\Webhook\Review::__invoke
     */
    public function testInvoke()
    {
        $mockReviewStorage = $this
            ->getMockBuilder(PageReviewStorageInterface::class)
            ->getMock()
        ;
        $action = new Review($mockReviewStorage);
        /** @var Response $response */
        $response = $action(new Request());
        static::assertEquals($response->getStatusCode(), Response::HTTP_ACCEPTED);
    }
}
