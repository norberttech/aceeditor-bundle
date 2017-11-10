<?php

namespace Sukovanej\AceEditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sukovanej_ace_editor');

        $rootNode
            ->children()
                ->booleanNode('autoinclude')->defaultTrue()->end()
                ->scalarNode('base_path')->defaultValue('vendor/ace')->end()
                ->booleanNode('debug')->defaultFalse()->end()
                ->booleanNode('noconflict')->defaultTrue()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
