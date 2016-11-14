<?php

namespace FL\FacebookPagesBundle\Action\Webhook;

use FL\FacebookPagesBundle\Storage\PageReviewStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Review
{
    /**
     * @var PageReviewStorageInterface
     */
    private $pageReviewsStorage;

    /**
     * @param PageReviewStorageInterface $pageReviewsStorage
     */
    public function __construct(PageReviewStorageInterface $pageReviewsStorage)
    {
        $this->pageReviewsStorage = $pageReviewsStorage;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        // todo persist review
        // todo use verify token
        $jsonObject = json_decode($request->getContent(), true);
        if ($jsonObject === null) {
            $jsonObject = [];
        }
        // verification only
        return new Response($request->get('hub_challenge'), Response::HTTP_ACCEPTED, ['Content-Type' => 'application/json']);
    }
}
