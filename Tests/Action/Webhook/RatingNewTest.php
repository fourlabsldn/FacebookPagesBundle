<?php

namespace FL\FacebookPagesBundle\Tests\Action\Webhook;

use FL\FacebookPagesBundle\Action\Webhook\RatingNew;
use FL\FacebookPagesBundle\Storage\PageRatingStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RatingNewTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Action\Webhook\RatingNew::__construct
     * @covers \FL\FacebookPagesBundle\Action\Webhook\RatingNew::__invoke
     */
    public function testInvoke()
    {
        $mockRatingStorage = $this
            ->getMockBuilder(PageRatingStorageInterface::class)
            ->getMock()
        ;
        $action = new RatingNew($mockRatingStorage);
        /** @var Response $response */
        $response = $action(new Request());
        $this->assertEquals($response->getStatusCode(), 200);
    }
}
