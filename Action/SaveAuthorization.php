<?php

namespace FL\FacebookPagesBundle\Action;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use FL\FacebookPagesBundle\Storage\FacebookUserStorageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveAuthorization
{
    /**
     * @var FacebookUserClient
     */
    private $facebookUserClient;

    /**
     * @var FacebookUserStorageInterface
     */
    private $facebookUserStorage;

    /**
     * @param FacebookUserClient $facebookUserClient
     * @param FacebookUserStorageInterface $facebookUserStorage
     *
     * @link https://developers.facebook.com/docs/facebook-login/permissions
     */
    public function __construct(
        FacebookUserClient $facebookUserClient,
        FacebookUserStorageInterface $facebookUserStorage
    ) {
        $this->facebookUserClient = $facebookUserClient;
        $this->facebookUserStorage = $facebookUserStorage;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        // todo persist user
        return new Response('', 200);
    }
}
