<?php

namespace FL\FacebookPagesBundle\DependencyInjection;

use FL\FacebookPagesBundle\Model\PageManagerInterface;
use FL\FacebookPagesBundle\Model\PageInterface;
use FL\FacebookPagesBundle\Model\PageReviewInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @see http://symfony.com/doc/current/cookbook/bundles/extension.html
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
        $container->setParameter('fl_facebook_pages.redirect_url_after_authorization', $config['redirect_url_after_authorization']);
        if ($config['only_these_page_ids'] === []) {
            $config['only_these_page_ids'] = null;
        }
        $container->setParameter('fl_facebook_pages.only_these_page_ids', $config['only_these_page_ids']);

        /*
         * Validate Model Classes Parameters
         */
        $this->validateClassNameIsInstanceOfAnother($config['page_manager_class'], PageManagerInterface::class, 'fl_facebook_pages.page_manager_class');
        $this->validateClassNameIsInstanceOfAnother($config['page_class'], PageInterface::class, 'fl_facebook_pages.page_class');
        $this->validateClassNameIsInstanceOfAnother($config['page_review_class'], PageReviewInterface::class, 'fl_facebook_pages.page_review_class');

        /*
         * Set Model Classes Parameters
         */
        $container->setParameter('fl_facebook_pages.page_manager_class', $config['page_manager_class']);
        $container->setParameter('fl_facebook_pages.page_class', $config['page_class']);
        $container->setParameter('fl_facebook_pages.page_review_class', $config['page_review_class']);

        /*
         * Set storage service aliases
         * These cannot be validated until we have a container.
         */
        $container->setAlias('fl_facebook_pages.page_manager_storage', $config['page_manager_storage']);
        $container->setAlias('fl_facebook_pages.page_storage', $config['page_storage']);
        $container->setAlias('fl_facebook_pages.page_review_storage', $config['page_review_storage']);

        /*
         * Set guzzle client alias
         * This cannot be validated until we have a container.
         */
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
