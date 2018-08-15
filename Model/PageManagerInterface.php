<?php

namespace FL\FacebookPagesBundle\Model;

/**
 * @see https://developers.facebook.com/docs/facebook-login/access-tokens/#usertokens
 */
interface PageManagerInterface
{
    /**
     * @return string|null
     */
    public function getShortLivedToken();

    /**
     * @param string|null $token
     *
     * @return PageManagerInterface
     */
    public function setShortLivedToken(string $token = null): self;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getShortLivedTokenExpiration();

    /**
     * @param $expiration \DateTimeImmutable|null
     *
     * @return PageManagerInterface
     */
    public function setShortLivedTokenExpiration(\DateTimeImmutable $expiration = null): self;

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
     * @return PageManagerInterface
     */
    public function setLongLivedToken(string $token = null): self;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getLongLivedTokenExpiration();

    /**
     * @param $expiration \DateTimeImmutable|null
     *
     * @return PageManagerInterface
     */
    public function setLongLivedTokenExpiration(\DateTimeImmutable $expiration = null): self;

    /**
     * @return bool
     */
    public function isLongLivedTokenExpired(): bool;

    /**
     * @return string|null
     */
    public function getUserId();

    /**
     * @param string|null $userId
     *
     * @return PageManagerInterface
     */
    public function setUserId(string $userId = null): self;
}
