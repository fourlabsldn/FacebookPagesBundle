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
                ->scalarNode('facebook_user_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('page_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('page_rating_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('facebook_user_storage')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('page_storage')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('page_rating_storage')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
