<?php

namespace FL\FacebookPagesBundle\Action\Webhook;

use FL\FacebookPagesBundle\Model\PageRating;
use FL\FacebookPagesBundle\Storage\PageRatingStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RatingNew
{
    /**
     * @var PageRatingStorageInterface
     */
    private $pageRatingsStorage;

    /**
     * @param PageRatingStorageInterface $pageRatingsStorage
     */
    public function __construct(PageRatingStorageInterface $pageRatingsStorage)
    {
        $this->pageRatingsStorage = $pageRatingsStorage;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        // todo get Request from rating
        $ratingFromRequest = new PageRating();
        $this->pageRatingsStorage->persist($ratingFromRequest);

        return new Response('', 200);
    }
}
