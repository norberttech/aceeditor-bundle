<?php

declare(strict_types=1);

namespace AceEditorBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AceEditorExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->registerAceEditorParameters($config, $container);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('form.xml');
        $loader->load('twig.xml');
    }

    /**
     * Register parameters for the DI.
     */
    private function registerAceEditorParameters(array $config, ContainerBuilder $container): void
    {
        // use debug from the kernel.debug, but we can force it via "debug"
        $debug = $container->getParameter('kernel.debug');
        if (!$debug && $config['debug']) {
            $debug = true;
        }

        $mode = 'src'.($debug ? '' : '-min').($config['noconflict'] ? '-noconflict' : '');

        $container->setParameter('ace_editor.options.autoinclude', $config['autoinclude']);
        $container->setParameter('ace_editor.options.base_path', $config['base_path']);
        $container->setParameter('ace_editor.options.mode', $mode);
    }
}
