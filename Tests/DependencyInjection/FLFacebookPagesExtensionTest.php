<?php

namespace FL\FacebookPagesBundle\Tests\DependencyInjection;

use FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension;
use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageReview;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FLFacebookPagesExtensionTest extends TestCase
{
    /**
     * @var ContainerBuilder
     */
    protected $container;

    /**
     * @var FLFacebookPagesExtension
     */
    protected $extension;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new FLFacebookPagesExtension();
    }

    public function testValidConfiguration()
    {
        $this->extension->load($this->createValidConfiguration(), $this->container);
    }

    public function testInvalidPageManagerClassConfiguration()
    {
        self::expectException(InvalidConfigurationException::class);

        $this->extension->load(
            array_merge($this->createValidConfiguration(), [['page_manager_class' => \DateTimeImmutable::class]]),
            $this->container
        );
    }

    public function testInvalidPageClassConfiguration()
    {
        self::expectException(InvalidConfigurationException::class);

        $this->extension->load(
            array_merge($this->createValidConfiguration(), [['page_class' => \DateTimeImmutable::class]]),
            $this->container
        );
    }

    public function testInvalidPageReviewClassConfiguration()
    {
        self::expectException(InvalidConfigurationException::class);

        $this->extension->load(
            array_merge($this->createValidConfiguration(), [['page_review_class' => \DateTimeImmutable::class]]),
            $this->container
        );
    }

    /**
     * @return array
     */
    protected function createValidConfiguration()
    {
        return [
            'fl_facebook_pages' => [
                'app_id' => 'fakeAppId',
                'app_secret' => 'fakePageSecret',
                'page_manager_class' => PageManager::class,
                'page_class' => Page::class,
                'page_review_class' => PageReview::class,
                'page_manager_storage' => '@fake_facebook_user_storage_service_alias',
                'page_storage' => '@fake_page_storage_service_alias',
                'page_review_storage' => '@fake_page_review_storage_service_alias',
                'guzzle_service' => '@fake_guzzle_service',
                'redirect_url_after_authorization' => 'http://example.com/hello',
                'only_these_page_ids' => [],
            ],
        ];
    }
}
