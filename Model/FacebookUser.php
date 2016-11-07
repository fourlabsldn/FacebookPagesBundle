<?php

namespace FL\FacebookPagesBundle\Model;

class FacebookUser implements FacebookUserInterface
{
    /**
     * @var string|null
     */
    protected $shortLivedToken;

    /**
     * @var \DateTimeImmutable|null
     */
    protected $shortLivedTokenExpiration;

    /**
     * @var string|null
     */
    protected $longLivedToken;

    /**
     * @var \DateTimeImmutable|null
     */
    protected $longLivedTokenExpiration;

    /**
     * @var string|null
     */
    protected $userId;

    /**
     * {@inheritdoc}
     */
    public function getShortLivedToken()
    {
        return $this->shortLivedToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setShortLivedToken(string $token = null): FacebookUserInterface
    {
        $this->shortLivedToken = $token;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getShortLivedTokenExpiration()
    {
        return $this->shortLivedTokenExpiration;
    }

    /**
     * {@inheritdoc}
     */
    public function setShortLivedTokenExpiration(\DateTimeImmutable $expiration = null): FacebookUserInterface
    {
        $this->shortLivedTokenExpiration = $expiration;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isShortLivedTokenExpired(): bool
    {
        if (
            (is_string($this->shortLivedToken)) &&
            (new \DateTimeImmutable('now') < $this->shortLivedTokenExpiration)
        ) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getLongLivedToken()
    {
        return $this->longLivedToken;
    }

    /**
     * {@inheritdoc}
     */
    public function setLongLivedToken(string $token = null): FacebookUserInterface
    {
        $this->longLivedToken = $token;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLongLivedTokenExpiration()
    {
        return $this->longLivedTokenExpiration;
    }

    /**
     * {@inheritdoc}
     */
    public function setLongLivedTokenExpiration(\DateTimeImmutable $expiration = null): FacebookUserInterface
    {
        $this->longLivedTokenExpiration = $expiration;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isLongLivedTokenExpired(): bool
    {
        if (
            (is_string($this->longLivedToken)) &&
            (new \DateTimeImmutable('now') < $this->longLivedTokenExpiration)
        ) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * {@inheritdoc}
     */
    public function setUserId(string $userId = null): FacebookUserInterface
    {
        $this->userId = $userId;

        return $this;
    }
}
