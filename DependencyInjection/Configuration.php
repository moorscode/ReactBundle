<?php

namespace Limenius\ReactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('limenius_react');
        $treeBuilder->getRootNode()
            ->children()
                ->enumNode('default_rendering')
                    ->values(array(1, 2, 3))
                    ->defaultValue(3)
                ->end()
                ->arrayNode('serverside_rendering')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('fail_loud')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('trace')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('server_bundle_path')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('server_socket_path')
                            ->defaultNull()
                        ->end()
                        ->arrayNode('cache')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultFalse()
                                ->end()
                                ->scalarNode('key')
                                    ->defaultValue('app')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
