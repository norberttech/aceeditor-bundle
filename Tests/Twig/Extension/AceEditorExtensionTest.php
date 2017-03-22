<?php

namespace Norzechowicz\AceEditorBundle\Tests\Twig\Extension;

use Norzechowicz\AceEditorBundle\Twig\Extension\AceEditorExtension;
use Symfony\Bridge\Twig\Extension\AssetExtension;

/**
 * @author azzra <azzra@users.noreply.github.com>
 */
class AceEditorExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param bool   $autoinclude
     * @param string $basePath
     * @param string $mode
     *
     * @return AceEditorExtension
     */
    private function getExtension($autoinclude = true, $basePath = '', $mode = '')
    {
        return new AceEditorExtension($autoinclude, $basePath, $mode);
    }

    /**
     * @return \Twig_Environment
     */
    private function getTwigEnvironment()
    {
        return $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetName()
    {
        $extension = $this->getExtension();
        $this->assertSame('ace_editor', $extension->getName());
    }

    public function testGetFunctions()
    {
        $extension = $this->getExtension();
        $functions = $extension->getFunctions();
        $this->assertSame(['include_ace_editor'], array_keys($functions));
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage "asset" extension is mandatory if you don't include Ace editor by yourself.
     */
    public function testIncludeAceEditorTwigNoExtensionAsset()
    {
        $environment = $this->getTwigEnvironment();
        $extension = $this->getExtension();
        $environment->method('hasExtension')->with(AssetExtension::class)->willReturn(false);

        $extension->initRuntime($environment);
        $extension->includeAceEditor();
    }

    public function testIncludeAceEditorTwig()
    {
        $environment = $this->getTwigEnvironment();
        $extension = $this->getExtension();
        $environment->method('hasExtension')->with(AssetExtension::class)->willReturn(true);

        $asset = $this->getMockBuilder(AssetExtension::class)
            ->disableOriginalConstructor()
            ->getMock();
        $asset->method('getAssetUrl')
            ->willReturnCallback(function ($file) {
                return $file;
            });

        $environment->method('getExtension')->with(AssetExtension::class)->willReturn($asset);
        $extension->initRuntime($environment);

        ob_start();
        $extension->includeAceEditor();
        $text = ob_get_clean();
        $this->assertSame(
            '<script src="//ace.js" charset="utf-8" type="text/javascript"></script><script src="//ext-language_tools.js" charset="utf-8" type="text/javascript"></script>',
            $text
        );

        ob_start();
        $extension->includeAceEditor();
        $text = ob_get_clean();
        $this->assertSame('', $text);
    }
}
