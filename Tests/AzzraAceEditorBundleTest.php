<?php

namespace Azzra\AceEditorBundle\Tests;

use Azzra\AceEditorBundle\AzzraAceEditorBundle;
use Azzra\AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class AzzraAceEditorBundleTest extends TestCase
{
    public function testBuild()
    {
        $container = new ContainerBuilder();
        $bundle = new AzzraAceEditorBundle();
        $bundle->build($container);

        $this->assertNotEmpty(array_filter(
            $container->getCompilerPassConfig()->getPasses(),
            function ($value) {
                return $value instanceof TwigFormPass;
            }
        ));
    }
}
