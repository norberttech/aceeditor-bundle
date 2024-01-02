<?php

declare(strict_types=1);

namespace NorbertTech\AceEditorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigFormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('twig.form.resources')) {
            return;
        }

        $container->setParameter('twig.form.resources', array_merge(
            [$container->getParameter('norberttech_ace_editor.form.resource')],
            $container->getParameter('twig.form.resources')
        ));
    }
}
