<?php

declare(strict_types=1);

namespace NorbertTech\AceEditorBundle;

use NorbertTech\AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NorbertTechAceEditorBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new TwigFormPass());
    }
}
