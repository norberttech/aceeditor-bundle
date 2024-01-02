<?php

declare(strict_types=1);

namespace NorbertTech\AceEditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('ace_editor');
        $rootNode = $treeBuilder->getRootNode();

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
