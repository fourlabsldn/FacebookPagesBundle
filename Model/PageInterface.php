<?php

namespace FL\FacebookPagesBundle\Model;

/**
 * @link https://developers.facebook.com/docs/facebook-login/access-tokens/#pagetokens
 * @link https://developers.facebook.com/docs/pages/access-tokens
 */
interface PageInterface
{
    /**
     * @return string|null
     */
    public function getShortLivedToken();

    /**
     * @param string|null $token
     *
     * @return PageInterface
     */
    public function setShortLivedToken(string $token = null): PageInterface;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getShortLivedTokenExpiration();

    /**
     * @param $expiration \DateTimeImmutable|null
     *
     * @return PageInterface
     */
    public function setShortLivedTokenExpiration(\DateTimeImmutable $expiration = null): PageInterface;

    /**
     * @return bool
     */
    public function isShortLivedTokenExpired(): bool;

    /**
     * @return string|null
     */
    public function getLongLivedToken();

    /**
     * @param string|null $token
     *
     * @return PageInterface
     */
    public function setLongLivedToken(string $token = null): PageInterface;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getLongLivedTokenExpiration();

    /**
     * @param $expiration \DateTimeImmutable|null
     *
     * @return PageInterface
     */
    public function setLongLivedTokenExpiration(\DateTimeImmutable $expiration = null): PageInterface;

    /**
     * @return bool
     */
    public function isLongLivedTokenExpired(): bool;

    /**
     * @return string|null
     */
    public function getPageId();

    /**
     * @param string|null $pageId
     *
     * @return PageInterface
     */
    public function setPageId(string $pageId = null): PageInterface;

    /**
     * @return string|null
     */
    public function getPageName();

    /**
     * @param string|null $pageName
     *
     * @return PageInterface
     */
    public function setPageName(string $pageName = null): PageInterface;

    /**
     * @return string|null
     */
    public function getCategory();

    /**
     * @param string|null $category
     *
     * @return PageInterface
     */
    public function setCategory(string $category = null);
}
