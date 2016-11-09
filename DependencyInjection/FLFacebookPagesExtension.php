<?php

namespace FL\FacebookPagesBundle\DependencyInjection;

use FL\FacebookPagesBundle\Model\FacebookUserInterface;
use FL\FacebookPagesBundle\Model\PageInterface;
use FL\FacebookPagesBundle\Model\PageRatingInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class FLFacebookPagesExtension extends Extension
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidConfigurationException
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        /*
         * Set String Parameters
         */
        $container->setParameter('fl_facebook_pages.app_id', $config['app_id']);
        $container->setParameter('fl_facebook_pages.app_secret', $config['app_secret']);
        $container->setParameter('fl_facebook_pages.callback_url', $config['callback_url']);
        $container->setParameter('fl_facebook_pages.redirect_url_after_authorization', $config['redirect_url_after_authorization']);
        if ($config['only_these_page_ids'] === []) {
            $config['only_these_page_ids'] = null;
        }
        $container->setParameter('fl_facebook_pages.only_these_page_ids', $config['only_these_page_ids']);

        /*
         * Validate Model Classes Parameters
         */
        $this->validateClassNameIsInstanceOfAnother($config['facebook_user_class'], FacebookUserInterface::class, 'fl_facebook_pages.facebook_user_class');
        $this->validateClassNameIsInstanceOfAnother($config['page_class'], PageInterface::class, 'fl_facebook_pages.page_class');
        $this->validateClassNameIsInstanceOfAnother($config['page_rating_class'], PageRatingInterface::class, 'fl_facebook_pages.page_rating_class');

        /*
         * Set Model Classes Parameters
         */
        $container->setParameter('fl_facebook_pages.facebook_user_class', $config['facebook_user_class']);
        $container->setParameter('fl_facebook_pages.page_class', $config['page_class']);
        $container->setParameter('fl_facebook_pages.page_rating_class', $config['page_rating_class']);

        /*
         * Set Storage Parameters
         * These cannot be validated until we have a container.
         */
        $container->setParameter('fl_facebook_pages.facebook_user_storage', $config['facebook_user_storage']);
        $container->setAlias('fl_facebook_pages.facebook_user_storage', $config['facebook_user_storage']);
        $container->setParameter('fl_facebook_pages.page_storage', $config['page_storage']);
        $container->setAlias('fl_facebook_pages.page_storage', $config['page_storage']);
        $container->setParameter('fl_facebook_pages.page_rating_storage', $config['page_rating_storage']);
        $container->setAlias('fl_facebook_pages.page_rating_storage', $config['page_rating_storage']);

        /*
         * Set Guzzle Client
         * This cannot be validated until we have a container.
         */
        $container->setParameter('fl_facebook_pages.guzzle_service', $config['guzzle_service']);
        $container->setAlias('fl_facebook_pages.guzzle_service', $config['guzzle_service']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * @param string $className
     * @param string $anotherClassName
     * @param string $parameter
     *
     * @throws InvalidConfigurationException
     */
    private function validateClassNameIsInstanceOfAnother(string $className, string $anotherClassName, string $parameter)
    {
        if (
            is_subclass_of($className, $anotherClassName) ||
            $className === $anotherClassName
        ) {
            return;
        }
        throw new InvalidConfigurationException(sprintf(
            'Class %s in %s is not an instance of %s',
            $className,
            $parameter,
            $anotherClassName
        ));
    }
}
