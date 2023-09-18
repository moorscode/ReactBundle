<?php

namespace MyOnlineStore\ReactBundle\DependencyInjection;

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
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('my_online_store_react');
        $treeBuilder->getRootNode()
            ->children()
                ->enumNode('default_rendering')
                    ->values(array('server_side', 'client_side', 'both'))
                    ->defaultValue('both')
                ->end()
                ->scalarNode('twig_function_prefix')
                    ->defaultValue('')
                ->end()
                ->scalarNode('dom_id_prefix')
                    ->defaultValue('mos_react')
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
                        ->arrayNode('cache')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->booleanNode('enabled')
                                    ->defaultFalse()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
