<?php

namespace FL\FacebookPagesBundle\Tests\DependencyInjection;

use FL\FacebookPagesBundle\DependencyInjection\Configuration;
use FL\FacebookPagesBundle\Model\FacebookUser;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Processor;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @var Processor
     */
    private $processor;

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
     */
    public function testValidConfigurationWorks()
    {
        $this->processor->processConfiguration(
            $this->configuration,
            [
                'fl_facebook_pages' => [
                        'facebook_user_class' => FacebookUser::class,
                        'page_class' => Page::class,
                        'facebook_user_storage' => FacebookUserStorage::class,
                        'page_class_storage' => PageStorage::class,
                    ],
            ]
        );
        $this->assertTrue(true);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\Configuration::getConfigTreeBuilder
     */
    public function testEmptyConfigurationsThrowException()
    {
        try {
            $this->processor->processConfiguration(
                $this->configuration,
                [
                    'fl_facebook_pages' => [
                            'facebook_user_class' => '',
                            'page_class' => '',
                            'facebook_user_storage' => '',
                            'page_class_storage' => '',
                        ],
                ]
            );
        } catch (InvalidConfigurationException $exception) {
            $this->assertTrue(true);

            return;
        }
        $this->fail();
    }
}
