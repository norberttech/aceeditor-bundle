<?php

declare(strict_types=1);

namespace NorbertTech\AceEditorBundle\Tests\DependencyInjection;

use NorbertTech\AceEditorBundle\DependencyInjection\NorbertTechAceEditorExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NorbertTechAceEditorExtensionTest extends TestCase
{
    /**
     * @dataProvider loadProvider
     */
    public function testLoad(array $parameters, bool $kernelDebug, array $expected): void
    {
        $extension = new NorbertTechAceEditorExtension();
        $container = new ContainerBuilder();

        $container->setParameter('kernel.debug', $kernelDebug);

        $extension->load([$parameters], $container);

        $result = [
            'autoinclude' => $container->getParameter('norberttech_ace_editor.options.autoinclude'),
            'base_path' => $container->getParameter('norberttech_ace_editor.options.base_path'),
            'mode' => $container->getParameter('norberttech_ace_editor.options.mode'),
        ];

        $this->assertSame($expected, $result);
    }

    public function loadProvider(): \Generator
    {
        yield [
            ['debug' => true, 'noconflict' => false],
            true,
            ['autoinclude' => true, 'base_path' => 'vendor/ace', 'mode' => 'src'],
        ];

        yield [
            ['debug' => true],
            false,
            ['autoinclude' => true, 'base_path' => 'vendor/ace', 'mode' => 'src-noconflict'],
        ];

        yield [
            ['debug' => false, 'base_path' => 'foo'],
            true,
            ['autoinclude' => true, 'base_path' => 'foo', 'mode' => 'src-noconflict'],
        ];

        yield [
            ['debug' => false, 'autoinclude' => false],
            false,
            ['autoinclude' => false, 'base_path' => 'vendor/ace', 'mode' => 'src-min-noconflict'],
        ];
    }
}
