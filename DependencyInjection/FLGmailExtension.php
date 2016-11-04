<?php

namespace FL\GmailBundle\DependencyInjection;

use FL\FacebookPagesBundle\Model\FacebookUserInterface;
use FL\FacebookPagesBundle\Model\PageInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class FLGmailExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (!($config['facebook_user_class'] instanceof FacebookUserInterface)) {
            throw new InvalidConfigurationException(sprintf(
                'Class set in fl_facebook_pages.facebook_user_class is not an instance of %s',
                FacebookUserInterface::class
            ));
        }
        if (!($config['page_class'] instanceof PageInterface)) {
            throw new InvalidConfigurationException(sprintf(
                'Class set in fl_facebook_pages.page_class is not an instance of %s',
                PageInterface::class
            ));
        }
//        if (!($config['page_rating_class'] instanceof Rating)) {
//            throw new InvalidConfigurationException(sprintf(
//                "Class set in fl_facebook_pages.page_rating_class is not an instance of %s",
//                Rating::class
//            ));
//        }

        $container->setParameter('fl_facebook_pages.facebook_user_class', $config['facebook_user_class']);
        $container->setParameter('fl_facebook_pages.page_class', $config['page_class']);
        $container->setParameter('fl_facebook_pages.page_rating_class', $config['page_rating_class']);
        if ($config['facebook_user_storage']) {
            $container->setParameter('fl_facebook_pages.facebook_user_storage', $config['facebook_user_storage']);
            $container->setAlias('fl_facebook_pages.facebook_user_storage', $config['facebook_user_storage']);
        }
        if ($config['page_class']) {
            $container->setParameter('fl_facebook_pages.page_class_storage', $config['page_class_storage']);
            $container->setAlias('fl_facebook_pages.page_class_storage', $config['page_class_storage']);
        }
//        if ($config['page_rating_storage']) {
//            $container->setParameter('fl_facebook_pages.page_rating_storage', $config['page_rating_storage']);
//            $container->setAlias('fl_facebook_pages.page_rating_storage', $config['page_rating_storage']);
//        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
