<?php

namespace FL\FacebookPagesBundle\Tests\DependencyInjection;

use FL\FacebookPagesBundle\DependencyInjection\Configuration;
use FL\FacebookPagesBundle\Model\FacebookUser;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageRating;
use FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageRatingStorage;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
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

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     * @covers \FL\FacebookPagesBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testValidConfigurationWorks()
    {
        $this->processor->processConfiguration(
            $this->configuration,
            [
                'fl_facebook_pages' => [
                    'app_id' => 'fakeAppId',
                    'app_secret'=> 'fakePageSecret',
                    'callback_url'=> 'http://example.com',
                    'facebook_user_class' => FacebookUser::class,
                    'page_class' => Page::class,
                    'page_rating_class' => PageRating::class,
                    'facebook_user_storage' => '@fake_facebook_user_storage_service_alias',
                    'page_storage' => '@fake_page_storage_service_alias',
                    'page_rating_storage' => '@fake_page_rating_storage_service_alias',
                    'guzzle_service' => '@fake_guzzle_service',
                ],
            ]
        );
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testEmptyConfigurationsThrowException()
    {
        $this->processor->processConfiguration(
            $this->configuration,
            [
                'fl_facebook_pages' => [
                        'facebook_user_class' => '',
                        'page_class' => '',
                        'page_rating_class' => '',
                        'facebook_user_storage' => '',
                        'page_storage' => '',
                        'page_rating_storage' => '',
                    ],
            ]
        );
    }
}
