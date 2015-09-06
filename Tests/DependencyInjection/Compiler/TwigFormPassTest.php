<?php

namespace Azzra\AceEditorBundle\Tests\DependencyInjection\Compiler;

use Azzra\AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class TwigFormPassTest extends TestCase
{
    public function testProcessHasNotTwigFormResources()
    {
        $container = $this->createMock(ContainerBuilder::class);
        $container->expects($this->once())->method('hasParameter')
            ->with('twig.form.resources')->willReturn(false);

        $container->expects($this->never())->method('setParameter');

        $compiler = new TwigFormPass();
        $compiler->process($container);
    }

    public function testProcessHasTwigFormResources()
    {
        $container = new ContainerBuilder();
        $container->setParameter('twig.form.resources', ['foo']);

        $compiler = new TwigFormPass();
        $compiler->process($container);

        $this->assertSame(
            ['AzzraAceEditorBundle:Form:div_layout.html.twig', 'foo'],
            $container->getParameter('twig.form.resources'));
    }
}
