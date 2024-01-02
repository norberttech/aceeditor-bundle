<?php

declare(strict_types=1);

namespace NorbertTech\AceEditorBundle\Tests;

use NorbertTech\AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use NorbertTech\AceEditorBundle\NorbertTechAceEditorBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NorbertTechAceEditorBundleTest extends TestCase
{
    public function testBuild(): void
    {
        $container = new ContainerBuilder();
        $bundle = new NorbertTechAceEditorBundle();
        $bundle->build($container);

        $this->assertNotEmpty(array_filter(
            $container->getCompilerPassConfig()->getPasses(),
            function ($value) {
                return $value instanceof TwigFormPass;
            }
        ));
    }
}
