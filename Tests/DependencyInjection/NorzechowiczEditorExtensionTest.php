<?php

namespace Norzechowicz\AceEditorBundle\Tests\DependencyInjection;

use Norzechowicz\AceEditorBundle\DependencyInjection\NorzechowiczAceEditorExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class NorzechowiczAceEditorExtensionTest extends TestCase
{
    /**
     * @dataProvider loadProvider
     *
     * @param array $parameters
     * @param bool  $kernelDebug
     * @param array $expected
     */
    public function testLoad(array $parameters, $kernelDebug, array $expected)
    {
        $extension = new NorzechowiczAceEditorExtension();
        $container = new ContainerBuilder();

        $container->setParameter('kernel.debug', $kernelDebug);

        $extension->load([$parameters], $container);

        $result = [
            'autoinclude' => $container->getParameter('norzechowicz_ace_editor.options.autoinclude'),
            'base_path' => $container->getParameter('norzechowicz_ace_editor.options.base_path'),
            'mode' => $container->getParameter('norzechowicz_ace_editor.options.mode'),
        ];

        $this->assertSame($expected, $result);
    }

    public function loadProvider()
    {
        return [
            [
                ['debug' => true, 'noconflict' => false],
                true,
                ['autoinclude' => true, 'base_path' => 'vendor/ace', 'mode' => 'src'],
            ],
            [
                ['debug' => true],
                false,
                ['autoinclude' => true, 'base_path' => 'vendor/ace', 'mode' => 'src-noconflict'],
            ],
            [
                ['debug' => false, 'base_path' => 'foo'],
                true,
                ['autoinclude' => true, 'base_path' => 'foo', 'mode' => 'src-noconflict'],
            ],
            [
                ['debug' => false, 'autoinclude' => false],
                false,
                ['autoinclude' => false, 'base_path' => 'vendor/ace', 'mode' => 'src-min-noconflict'],
            ],
        ];
    }
}
