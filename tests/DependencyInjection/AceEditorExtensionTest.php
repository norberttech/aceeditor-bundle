<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests\DependencyInjection;

use AceEditorBundle\DependencyInjection\AceEditorExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\UX\StimulusBundle\StimulusBundle;

class AceEditorExtensionTest extends TestCase
{
    /**
     * @param array<string, bool|float|int|string|null> $parameters
     * @param array<string, bool|float|int|string|null> $expected
     * @param array<int, string> $bundles
     *
     * @dataProvider loadProvider
     */
    public function testLoad(array $parameters, bool $kernelDebug, array $bundles, array $expected): void
    {
        $extension = new AceEditorExtension();
        $container = new ContainerBuilder();

        $container->setParameter('kernel.debug', $kernelDebug);
        $container->setParameter('kernel.bundles', $bundles);

        $extension->load([$parameters], $container);

        $result = [
            'autoinclude' => $container->getParameter('ace_editor.options.autoinclude'),
            'base_path' => $container->getParameter('ace_editor.options.base_path'),
            'mode' => $container->getParameter('ace_editor.options.mode'),
            'use_stimulus' => $container->getParameter('ace_editor.options.use_stimulus'),
        ];

        $this->assertSame($expected, $result);
    }

    public function loadProvider(): \Generator
    {
        yield [
            ['debug' => true, 'noconflict' => false],
            true,
            [],
            ['autoinclude' => true, 'base_path' => 'vendor/ace', 'mode' => 'src', "use_stimulus"=>false],
        ];

        yield [
            ['debug' => true],
            false,
            [],
            ['autoinclude' => true, 'base_path' => 'vendor/ace', 'mode' => 'src-noconflict', "use_stimulus"=>false],
        ];

        yield [
            ['debug' => false, 'base_path' => 'foo'],
            true,
            [],
            ['autoinclude' => true, 'base_path' => 'foo', 'mode' => 'src-noconflict', "use_stimulus"=>false],
        ];

        yield [
            ['debug' => false, 'autoinclude' => false],
            false,
            [],
            ['autoinclude' => false, 'base_path' => 'vendor/ace', 'mode' => 'src-min-noconflict', "use_stimulus"=>false],
        ];

        yield [
            ['debug' => false, 'autoinclude' => false],
            false,
            [StimulusBundle::class],
            ['autoinclude' => false, 'base_path' => 'vendor/ace', 'mode' => 'src-min-noconflict', "use_stimulus"=>true],
        ];

        yield [
            ['debug' => false, 'autoinclude' => false, 'use_stimulus'=>false],
            false,
            [StimulusBundle::class],
            ['autoinclude' => false, 'base_path' => 'vendor/ace', 'mode' => 'src-min-noconflict', "use_stimulus"=>false],
        ];

        yield [
            ['debug' => false, 'autoinclude' => false, 'use_stimulus'=>true],
            false,
            [],
            ['autoinclude' => false, 'base_path' => 'vendor/ace', 'mode' => 'src-min-noconflict', "use_stimulus"=>true],
        ];
    }
}
