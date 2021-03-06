<?php

namespace FlowFusion\BlogBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('flow_fusion_blog');

        $rootNode
            ->children()
                ->arrayNode('loop')
                ->children()
                    ->integerNode('page_limit')
                    ->defaultValue(10)
                    ->end()
                    ->integerNode('excerpt_length')
                    ->defaultValue(40)
                    ->end()
                    ->booleanNode('read_more_link')
                    ->defaultValue(true)
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

}
