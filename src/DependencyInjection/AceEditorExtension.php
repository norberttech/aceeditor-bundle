<?php

declare(strict_types=1);

namespace AceEditorBundle\DependencyInjection;

use Symfony\Component\AssetMapper\AssetMapperInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\UX\StimulusBundle\StimulusBundle;

class AceEditorExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $this->registerAceEditorParameters($config, $container);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('form.xml');
        $loader->load('twig.xml');
    }

    /**
     * Register parameters for the DI.
     *
     * @param array<string, bool|float|int|string|null> $config
     */
    private function registerAceEditorParameters(array $config, ContainerBuilder $container): void
    {
        // use debug from the kernel.debug, but we can force it via "debug"
        $debug = $container->getParameter('kernel.debug');
        if (!$debug && $config['debug']) {
            $debug = true;
        }

        $mode = 'src' . ($debug ? '' : '-min') . ($config['noconflict'] ? '-noconflict' : '');

        $useStimulus = $config['use_stimulus'];
        if ($useStimulus === null) {
            $bundles = $container->getParameter('kernel.bundles');
            assert(is_array($bundles));
            $useStimulus = in_array(StimulusBundle::class, $bundles, true) && interface_exists(AssetMapperInterface::class);
        }

        $container->setParameter('ace_editor.options.autoinclude', $config['autoinclude']);
        $container->setParameter('ace_editor.options.base_path', $config['base_path']);
        $container->setParameter('ace_editor.options.mode', $mode);
        $container->setParameter('ace_editor.options.use_stimulus', $useStimulus);
    }

    /**
     * @see https://symfony.com/doc/current/frontend/create_ux_bundle.html
     */
    public function prepend(ContainerBuilder $container)
    {
        if ($this->isAssetMapperAvailable($container)) {
            $container->prependExtensionConfig('framework', [
                'asset_mapper' => [
                    'paths' => [
                        __DIR__ . '/../../assets/controllers' => 'norberttech/aceeditor-bundle',
                    ],
                ],
            ]);
        }
    }

    private function isAssetMapperAvailable(ContainerBuilder $container): bool
    {
        if (!interface_exists(AssetMapperInterface::class)) {
            return false;
        }

        // check that FrameworkBundle 6.3 or higher is installed
        $bundlesMetadata = $container->getParameter('kernel.bundles_metadata');
        if (!isset($bundlesMetadata['FrameworkBundle'])) {
            return false;
        }

        return is_file($bundlesMetadata['FrameworkBundle']['path'] . '/Resources/config/asset_mapper.php');
    }
}
