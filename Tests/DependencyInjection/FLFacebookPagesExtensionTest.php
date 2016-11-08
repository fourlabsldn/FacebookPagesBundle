<?php

namespace FL\FacebookPagesBundle\Tests\DependencyInjection;

use FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension;
use FL\FacebookPagesBundle\Model\FacebookUser;
use FL\FacebookPagesBundle\Model\Page;
use FL\FacebookPagesBundle\Model\PageRating;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FLFacebookPagesExtensionTest extends \PHPUnit_Framework_TestCase
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

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension
     */
    public function testValidConfiguration()
    {
        $this->extension->load($this->createValidConfiguration(), $this->container);
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension::load
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension::validateClassNameIsInstanceOfAnother
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidFacebookUserClassConfiguration()
    {
        $this->extension->load(
            array_merge($this->createValidConfiguration(), [['facebook_user_class' => \DateTimeImmutable::class]]),
            $this->container
        );
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension::load
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension::validateClassNameIsInstanceOfAnother
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidPageClassConfiguration()
    {
        $this->extension->load(
            array_merge($this->createValidConfiguration(), [['page_class' => \DateTimeImmutable::class]]),
            $this->container
        );
    }

    /**
     * @test
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension::load
     * @covers \FL\FacebookPagesBundle\DependencyInjection\FLFacebookPagesExtension::validateClassNameIsInstanceOfAnother
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testInvalidPageRatingClassConfiguration()
    {
        $this->extension->load(
            array_merge($this->createValidConfiguration(), [['page_rating_class' => \DateTimeImmutable::class]]),
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
        ];
    }
}
