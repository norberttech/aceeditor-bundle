<?php

namespace Norzechowicz\AceEditorBundle;

use Norzechowicz\AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NorzechowiczAceEditorBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new TwigFormPass());
    }
}
