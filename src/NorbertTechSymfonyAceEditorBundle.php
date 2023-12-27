<?php

declare(strict_types=1);

namespace NorbertTech\SymfonyAceEditorBundle;

use NorbertTech\SymfonyAceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NorbertTechSymfonyAceEditorBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new TwigFormPass());
    }
}
