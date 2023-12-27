<?php

declare(strict_types=1);

namespace NorbertTech\SymfonyAceEditorBundle\Tests;

use NorbertTech\SymfonyAceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use NorbertTech\SymfonyAceEditorBundle\NorbertTechSymfonyAceEditorBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NorbertTechSymfonyAceEditorBundleTest extends TestCase
{
    public function testBuild(): void
    {
        $container = new ContainerBuilder();
        $bundle = new NorbertTechSymfonyAceEditorBundle();
        $bundle->build($container);

        $this->assertNotEmpty(array_filter(
            $container->getCompilerPassConfig()->getPasses(),
            function ($value) {
                return $value instanceof TwigFormPass;
            }
        ));
    }
}
