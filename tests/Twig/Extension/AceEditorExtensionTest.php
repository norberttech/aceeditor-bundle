<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests\Twig\Extension;

use AceEditorBundle\Twig\Extension\AceEditorExtension;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Extension\AssetExtension;
use Symfony\Component\Asset\Packages;
use Symfony\Component\Asset\PathPackage;
use Symfony\Component\Asset\VersionStrategy\EmptyVersionStrategy;
use Twig\Environment;

/**
 * @internal
 */
final class AceEditorExtensionTest extends TestCase
{
    public function testGetName(): void
    {
        $extension = $this->getExtension();
        self::assertSame('ace_editor', $extension->getName());
    }

    public function testGetFunctions(): void
    {
        $extension = $this->getExtension();
        $functions = $extension->getFunctions();
        self::assertSame(['include_ace_editor'], array_keys($functions));
    }

    public function testIncludeAceEditorTwigNoExtensionAsset(): void
    {
        $this->expectException(\LogicException::class);
        $this->expectExceptionMessage('"asset" extension is mandatory if you do not include Ace editor by yourself');

        $environment = $this->getTwigEnvironment();
        $extension = $this->getExtension();
        $environment->method('hasExtension')->with(AssetExtension::class)->willReturn(false);

        $extension->includeAceEditor($environment);
    }

    public function testIncludeAceEditorTwig(): void
    {
        $environment = $this->getTwigEnvironment();
        $extension = $this->getExtension();
        $environment->method('hasExtension')->with(AssetExtension::class)->willReturn(true);

        $asset = new AssetExtension(new Packages(new PathPackage('/', new EmptyVersionStrategy())));

        $environment->method('getExtension')->with(AssetExtension::class)->willReturn($asset);

        ob_start();
        $extension->includeAceEditor($environment);
        $text = ob_get_clean();
        self::assertSame(
            '<script src="//ace.js" charset="utf-8" type="text/javascript"></script><script src="//ext-language_tools.js" charset="utf-8" type="text/javascript"></script>',
            $text
        );

        ob_start();
        $extension->includeAceEditor($environment);
        $text = ob_get_clean();
        self::assertSame('', $text);
    }

    private function getExtension(bool $autoInclude = true, string $basePath = '', string $mode = ''): AceEditorExtension
    {
        return new AceEditorExtension($autoInclude, $basePath, $mode);
    }

    private function getTwigEnvironment(): Environment&MockObject
    {
        return $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}
