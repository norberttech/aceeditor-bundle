<?php

namespace Norzechowicz\AceEditorBundle\Tests;

use Norzechowicz\AceEditorBundle\NorzechowiczAceEditorBundle;
use Norzechowicz\AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NorzechowiczAceEditorBundleTest extends TestCase
{
    public function testBuild()
    {
        $container = new ContainerBuilder();
        $bundle = new NorzechowiczAceEditorBundle();
        $bundle->build($container);

        $this->assertNotEmpty(array_filter(
            $container->getCompilerPassConfig()->getPasses(),
            function ($value) {
                return $value instanceof TwigFormPass;
            }
        ));
    }
}
