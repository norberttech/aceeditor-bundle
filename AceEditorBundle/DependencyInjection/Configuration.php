<?php

/**
 * This file is part of the AceEditorBundle.
 *
 * (c) Norbert Orzechowicz <norbert@orzechowicz.pl>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Norzechowicz\AceEditorBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Norbert Orzechowicz <norbert@fsi.pl>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('norzechowicz_ace_editor');

        $rootNode
            ->children()
                ->booleanNode('autoinclude')->defaultTrue()->end()
                ->scalarNode('base_path')->defaultValue('bundles/norzechowiczaceeditor/ace')->end()
                ->booleanNode('debug')->defaultFalse()->end()
                ->booleanNode('noconflict')->defaultTrue()->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
