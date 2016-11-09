<?php

namespace FL\FacebookPagesBundle\Action;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use FL\FacebookPagesBundle\Storage\FacebookUserStorageInterface;
use FL\FacebookPagesBundle\Storage\PageStorageInterface;
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
     * @var PageStorageInterface
     */
    private $pageStorage;

    /**
     * @var null|string[]
     */
    private $onlyThesePageIds;

    /**
     * @param FacebookUserClient           $facebookUserClient
     * @param FacebookUserStorageInterface $facebookUserStorage
     * @param PageStorageInterface         $pageStorage
     * @param string[]                     $onlyThesePageIds
     *
     * @link https://developers.facebook.com/docs/facebook-login/permissions
     */
    public function __construct(
        FacebookUserClient $facebookUserClient,
        FacebookUserStorageInterface $facebookUserStorage,
        PageStorageInterface $pageStorage,
        array $onlyThesePageIds = null
    ) {
        $this->facebookUserClient = $facebookUserClient;
        $this->facebookUserStorage = $facebookUserStorage;
        $this->pageStorage = $pageStorage;
        $this->onlyThesePageIds = $onlyThesePageIds;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $user = $this->facebookUserClient->generateUserFromAuthorizationRequest($request);
        $this->facebookUserStorage->persist($user);

        $userPages = $this->facebookUserClient->resolveUserPages($user);
        if ($this->onlyThesePageIds === null || count($this->onlyThesePageIds) === 0) {
            $this->pageStorage->persistMultiple($userPages);

            return new Response('Authenticated!', 200);
        }

        $pagesToPersist = [];
        foreach ($userPages as $page) {
            if (in_array($page->getPageId(), $this->onlyThesePageIds)) {
                $pagesToPersist[] = $page;
            }
        }
        $this->pageStorage->persistMultiple($pagesToPersist);

        return new Response('Authenticated!', 200);
    }
}
