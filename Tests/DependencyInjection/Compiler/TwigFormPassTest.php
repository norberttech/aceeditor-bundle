<?php

namespace Norzechowicz\AceEditorBundle\Tests\DependencyInjection\Compiler;

use Norzechowicz\AceEditorBundle\DependencyInjection\Compiler\TwigFormPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @author azzra <azzra@users.noreply.github.com>
 */
class TwigFormPassTest extends \PHPUnit_Framework_TestCase
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
            ['NorzechowiczAceEditorBundle:Form:div_layout.html.twig', 'foo'],
            $container->getParameter('twig.form.resources'));
    }
}
