<?php

namespace FL\FacebookPagesBundle\Tests\DependencyInjection;

use FL\FacebookPagesBundle\DependencyInjection\Configuration;
use FL\FacebookPagesBundle\Model\PageManager;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageReview;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends TestCase
{
    /**
     * @var Configuration
     */
    protected $configuration;

    /**
     * @var Processor
     */
    protected $processor;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    public function testValidConfigurationWorks()
    {
        $this->processor->processConfiguration(
            $this->configuration,
            [
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
            ]
        );
    }

    public function testEmptyConfigurationsThrowException()
    {
        self::expectException(InvalidConfigurationException::class);

        $this->processor->processConfiguration(
            $this->configuration,
            [
                'fl_facebook_pages' => [
                    'app_id' => '',
                    'app_secret' => '',
                    'page_manager_class' => '',
                    'page_class' => '',
                    'page_review_class' => '',
                    'page_manager_storage' => '',
                    'page_storage' => '',
                    'page_review_storage' => '',
                    'guzzle_service' => '',
                    'redirect_url_after_authorization' => '',
                    'only_these_page_ids' => [],
                    ],
            ]
        );
    }
}
