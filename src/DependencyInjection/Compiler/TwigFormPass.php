<?php

declare(strict_types=1);

namespace AceEditorBundle\DependencyInjection\Compiler;

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
            [$container->getParameter('ace_editor.form.resource')],
            (array) $container->getParameter('twig.form.resources')
        ));
    }
}
