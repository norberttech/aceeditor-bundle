<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests;

use AceEditorBundle\AceEditorBundle;
use AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @internal
 */
final class AceEditorBundleTest extends TestCase
{
    public function testBuild(): void
    {
        $container = new ContainerBuilder();
        $bundle = new AceEditorBundle();
        $bundle->build($container);

        self::assertNotEmpty(array_filter(
            $container->getCompilerPassConfig()->getPasses(),
            static function ($value) {
                return $value instanceof TwigFormPass;
            }
        ));
    }
}
