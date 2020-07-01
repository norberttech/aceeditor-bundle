<?php

declare(strict_types=1);

namespace Norzechowicz\AceEditorBundle\Tests\Twig\Extension;

use Norzechowicz\AceEditorBundle\Twig\Extension\AceEditorExtension;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Twig\Environment;

class AceEditorExtensionTest extends TestCase
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
     * @return Environment
     */
    private function getTwigEnvironment() : MockObject
    {
        return $this->getMockBuilder(Environment::class)
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

    public function testIncludeAceEditorTwigNoExtensionAsset()
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('"asset" extension is mandatory if you don\'t include Ace editor by yourself');

        $environment = $this->getTwigEnvironment();
        $extension = $this->getExtension();
        $environment->method('hasExtension')->with(AssetExtension::class)->willReturn(false);

        $extension->includeAceEditor($environment);
    }

    public function testIncludeAceEditorTwig()
    {
        $environment = $this->getTwigEnvironment();
        $extension = $this->getExtension();
        $environment->method('hasExtension')->with(AssetExtension::class)->willReturn(true);

        $asset = new AssetExtension(new Packages(new PathPackage('/', new EmptyVersionStrategy())));

        $environment->method('getExtension')->with(AssetExtension::class)->willReturn($asset);

        ob_start();
        $extension->includeAceEditor($environment);
        $text = ob_get_clean();
        $this->assertSame(
            '<script src="//ace.js" charset="utf-8" type="text/javascript"></script><script src="//ext-language_tools.js" charset="utf-8" type="text/javascript"></script>',
            $text
        );

        ob_start();
        $extension->includeAceEditor($environment);
        $text = ob_get_clean();
        $this->assertSame('', $text);
    }
}
