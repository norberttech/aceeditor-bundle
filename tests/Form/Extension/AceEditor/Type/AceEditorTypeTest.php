<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests\Form\Extension\AceEditor\Type;

use AceEditorBundle\AutocompleteTreeBuilder;
use AceEditorBundle\Form\Extension\AceEditor\Type\AceEditorType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @internal
 */
final class AceEditorTypeTest extends TestCase
{
    /** @var AceEditorType<mixed> */
    private AceEditorType $formType;

    protected function setUp(): void
    {
        $this->formType = new AceEditorType(false);
    }

    public function testGetParent(): void
    {
        self::assertSame(TextareaType::class, $this->formType->getParent());
    }

    public function testOptionsWidthHeightUnitNormalizer(): void
    {
        $opts = new OptionsResolver();
        $this->formType->configureOptions($opts);

        $resolved = $opts->resolve(['width' => null, 'height' => null]);
        self::assertSame(['value' => null, 'unit' => 'px'], $resolved['width']);
        self::assertSame(['value' => null, 'unit' => 'px'], $resolved['height']);

        $resolved = $opts->resolve(['width' => 20, 'height' => '20']);
        self::assertSame(['value' => 20, 'unit' => 'px'], $resolved['width']);
        self::assertSame(['value' => '20', 'unit' => 'px'], $resolved['height']);

        $resolved = $opts->resolve(['width' => '50%']);
        self::assertSame(['value' => '50', 'unit' => '%'], $resolved['width']);

        $resolved = $opts->resolve(['width' => '101foo']);
        self::assertSame(['value' => '101foo', 'unit' => 'px'], $resolved['width']);
    }

    public function testPopulateAutocompleteWorlds(): void
    {
        $autocomplete = [
            'foo' => [
                'bar' => [
                    'baz' => true,
                ],
                'qux' => false,
                'quux' => ['corge', 'grault'],
            ],
            'garply' => ['waldo'],
        ];
        $opts = new OptionsResolver();
        $this->formType->configureOptions($opts);
        $resolved = $opts->resolve([
            'autocomplete_words' => ['foos'],
            'autocomplete_builder' => new AutocompleteTreeBuilder($autocomplete),
        ]);

        $view = new FormView();
        $form = $this->createMock(FormInterface::class);
        $this->formType->buildView($view, $form, $resolved);
        $words = $view->vars['autocomplete_words'];

        $expected = [
            0 => 'foos',
            1 => [
                'value' => 'foo',
                'meta' => null,
                'score' => 1,
            ],
            2 => [
                'value' => 'foo.bar',
                'meta' => null,
                'score' => 1,
            ],
            3 => [
                'value' => 'foo.bar.baz',
                'meta' => null,
                'score' => 1,
            ],
            4 => [
                'value' => 'foo.qux',
                'meta' => null,
                'score' => 1,
            ],
            5 => [
                'value' => 'foo.quux',
                'meta' => null,
                'score' => 1,
            ],
            6 => [
                'value' => 'foo.quux.corge',
                'meta' => null,
                'score' => 1,
            ],
            7 => [
                'value' => 'foo.quux.grault',
                'meta' => null,
                'score' => 1,
            ],
            8 => [
                'value' => 'garply',
                'meta' => null,
                'score' => 1,
            ],
            9 => [
                'value' => 'garply.waldo',
                'meta' => null,
                'score' => 1,
            ],
        ];

        self::assertSame($expected, $words);
    }
}
