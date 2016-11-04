<?php

namespace FL\FacebookPagesBundle\Model;

/**
 * @link https://developers.facebook.com/docs/facebook-login/access-tokens/#usertokens
 */
interface FacebookUserInterface
{
    /**
     * @return string|null
     */
    public function getShortLivedToken();

    /**
     * @param string|null $token
     *
     * @return FacebookUserInterface
     */
    public function setShortLivedToken(string $token = null): FacebookUserInterface;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getShortLivedTokenExpiration();

    /**
     * @param $expiration \DateTimeImmutable|null
     *
     * @return FacebookUserInterface
     */
    public function setShortLivedTokenExpiration(\DateTimeImmutable $expiration = null): FacebookUserInterface;

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
     * @return FacebookUserInterface
     */
    public function setLongLivedToken(string $token = null): FacebookUserInterface;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getLongLivedTokenExpiration();

    /**
     * @param $expiration \DateTimeImmutable|null
     *
     * @return FacebookUserInterface
     */
    public function setLongLivedTokenExpiration(\DateTimeImmutable $expiration = null): FacebookUserInterface;

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
     * @return FacebookUserInterface
     */
    public function setUserId(string $userId = null): FacebookUserInterface;
}