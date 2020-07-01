<?php

namespace Norzechowicz\AceEditorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class TwigFormPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasParameter('twig.form.resources')) {
            return;
        }

        $container->setParameter('twig.form.resources', array_merge(
            [$container->getParameter('norzechowicz_ace_editor.form.resource')],
            $container->getParameter('twig.form.resources')
        ));
    }
}
