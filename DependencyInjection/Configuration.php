<?php

namespace FL\FacebookPagesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @link http://symfony.com/doc/current/cookbook/bundles/configuration.html
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('fl_facebook_pages')->isRequired();

        $rootNode
            ->children()
                ->scalarNode('app_id')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('app_secret')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('page_manager_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('page_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('page_review_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('page_manager_storage')
                    ->cannotBeEmpty()
                    ->defaultValue('fl_facebook_pages.storage.doctrine.page_manager_storage')
                ->end()
                ->scalarNode('page_storage')
                    ->cannotBeEmpty()
                    ->defaultValue('fl_facebook_pages.storage.doctrine.page_storage')
                ->end()
                ->scalarNode('page_review_storage')
                    ->cannotBeEmpty()
                    ->defaultValue('fl_facebook_pages.storage.doctrine.page_review_storage')
                ->end()
                ->scalarNode('guzzle_service')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('redirect_url_after_authorization')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('only_these_page_ids')
                    ->defaultValue([])
                    ->prototype('scalar')
                    ->end()
                ->end()
            ->end()

        ;

        return $treeBuilder;
    }
}
