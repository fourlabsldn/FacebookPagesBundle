<?php

namespace FL\FacebookPagesBundle\Action\Webhook;

use FL\FacebookPagesBundle\Storage\PageRatingStorageInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        // todo persist rating
        // todo use verify token
        $jsonObject = json_decode($request->getContent(), true);
        if ($jsonObject === null) {
            $jsonObject = [];
        }
        if (array_key_exists('hub.challenge', $jsonObject)) {
            return new JsonResponse($jsonObject['hub.challenge'], 200);
        }
        else {
            return new JsonResponse([], 200);
        }
    }
}
