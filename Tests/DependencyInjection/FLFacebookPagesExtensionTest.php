<?php

namespace FL\FacebookPagesBundle\Tests\DependencyInjection;

use FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension;
use FL\FacebookPagesBundle\Model\FacebookUser;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Storage\DoctrineORM\FacebookUserStorage;
use FL\FacebookPagesBundle\Storage\DoctrineORM\PageStorage;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FLFacebookPagesExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var FLFacebookPagesExtension
     */
    private $extension;

    public function setUp()
    {
        $this->container = new ContainerBuilder();
        $this->extension = new FLFacebookPagesExtension();
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension
     */
    public function testLoad()
    {
        $this->extension->load([
            'fl_facebook_pages' => [
                'facebook_user_class' => FacebookUser::class,
                'page_class' => Page::class,
                'facebook_user_storage' => FacebookUserStorage::class,
                'page_class_storage' => PageStorage::class,
            ],
        ], $this->container);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension::load
     */
    public function testConfigurationExceptionBadFacebookUserClass()
    {
        try {
            $this->extension->load([
                'fl_facebook_pages' => [
                    'facebook_user_class' => Page::class,
                    'page_class' => Page::class,
                    'facebook_user_storage' => FacebookUserStorage::class,
                    'page_class_storage' => PageStorage::class,
                ],
            ], $this->container);
        } catch (InvalidConfigurationException $exception) {
            return;
        }

        $this->fail(sprintf('Expected %s when loading bad configuration.', InvalidConfigurationException::class));
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension::load
     */
    public function testConfigurationExceptionBadPageClass()
    {
        try {
            $this->extension->load([
               'fl_facebook_pages' => [
                   'facebook_user_class' => FacebookUser::class,
                   'page_class' => FacebookUser::class,
                   'facebook_user_storage' => FacebookUserStorage::class,
                   'page_class_storage' => PageStorage::class,
               ],
           ], $this->container);
        } catch (InvalidConfigurationException $exception) {
            return;
        }

        $this->fail(sprintf('Expected %s when loading bad configuration.', InvalidConfigurationException::class));
    }
}
