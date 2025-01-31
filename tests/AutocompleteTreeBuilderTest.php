<?php

declare(strict_types=1);

namespace AceEditorBundle\Tests;

use AceEditorBundle\AutocompleteItem;
use AceEditorBundle\AutocompleteTreeBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class AutocompleteTreeBuilderTest extends TestCase
{
    public function testBuildWords(): void
    {
        $autocomplete = [
            'foo' => [
                'bar' => [
                    'baz' => true,
                ],
                'qux'  => false,
                'quux' => ['corge', 'grault'],
            ],
            'garply' => ['waldo'],
        ];
        $builder = new AutocompleteTreeBuilder($autocomplete);
        self::assertEquals([
            new AutocompleteItem(value: 'foo'),
            new AutocompleteItem(value: 'foo.bar'),
            new AutocompleteItem(value: 'foo.bar.baz'),
            new AutocompleteItem(value: 'foo.qux'),
            new AutocompleteItem(value: 'foo.quux'),
            new AutocompleteItem(value: 'foo.quux.corge'),
            new AutocompleteItem(value: 'foo.quux.grault'),
            new AutocompleteItem(value: 'garply'),
            new AutocompleteItem(value: 'garply.waldo'),
        ], $builder->buildWords());
    }

    public function testSeparator(): void
    {
        $autocomplete = [
            'foo' => [
                'bar' => [
                    'baz' => true,
                ],
            ],
        ];
        $builder = new AutocompleteTreeBuilder($autocomplete, '->');
        self::assertEquals([
            new AutocompleteItem(value: 'foo'),
            new AutocompleteItem(value: 'foo->bar'),
            new AutocompleteItem(value: 'foo->bar->baz'),
        ], $builder->buildWords());
    }
}
