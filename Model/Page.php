<?php

namespace FL\FacebookPagesBundle\Model;

class Page implements PageInterface
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
    protected $pageId;

    /**
     * @var string|null
     */
    protected $pageName;

    /**
     * @var string|null
     */
    protected $category;

    /**
     * @var PageManagerInterface|null
     */
    protected $facebookUser;

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
    public function setShortLivedToken(string $token = null): PageInterface
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
    public function setShortLivedTokenExpiration(\DateTimeImmutable $expiration = null): PageInterface
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
    public function setLongLivedToken(string $token = null): PageInterface
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
    public function setLongLivedTokenExpiration(\DateTimeImmutable $expiration = null): PageInterface
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
    public function getPageId()
    {
        return $this->pageId;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageId(string $pageId = null): PageInterface
    {
        $this->pageId = $pageId;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageName()
    {
        return $this->pageName;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageName(string $pageName = null): PageInterface
    {
        $this->pageName = $pageName;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * {@inheritdoc}
     */
    public function setCategory(string $category = null): PageInterface
    {
        $this->category = $category;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPageManager()
    {
        return $this->facebookUser;
    }

    /**
     * {@inheritdoc}
     */
    public function setPageManager(PageManagerInterface $facebookUser = null): PageInterface
    {
        $this->facebookUser = $facebookUser;

        return $this;
    }
}
