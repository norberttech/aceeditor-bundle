<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests\DependencyInjection\Compiler;

use AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class TwigFormPassTest extends TestCase
{
    public function testProcessHasNotTwigFormResources(): void
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->once())->method('hasParameter')
            ->with('twig.form.resources')->willReturn(false);

        $container->expects($this->never())->method('setParameter');

        $compiler = new TwigFormPass();
        $compiler->process($container);
    }

    public function testProcessHasTwigFormResources(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('twig.form.resources', ['foo']);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../../src/Resources/config'));
        $loader->load('form.xml');

        $compiler = new TwigFormPass();
        $compiler->process($container);

        $this->assertSame(
            ['@AceEditor/Form/div_layout.html.twig', 'foo'],
            $container->getParameter('twig.form.resources')
        );
    }
}
