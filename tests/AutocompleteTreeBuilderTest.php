<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Jozef Môstka
 * Date: 1. 1. 2025
 * Time: 10:12
 */

namespace AceEditorBundle\Tests;

use AceEditorBundle\AutocompleteItem;
use AceEditorBundle\AutocompleteTreeBuilder;
use PHPUnit\Framework\TestCase;

class AutocompleteTreeBuilderTest extends TestCase
{
    public function testBuildWords(): void
    {
        $autocomplete = [
            "foo" => [
                "bar" => [
                    "baz" => true,
                ],
                "qux" => false,
                "quux" => ["corge", "grault"],
            ],
            "garply" => ["waldo"],
        ];
        $builder = new AutocompleteTreeBuilder($autocomplete);
        $this->assertEquals([
            0 => new AutocompleteItem(value: 'foo'),
            1 => new AutocompleteItem(value: 'foo.bar'),
            2 => new AutocompleteItem(value: 'foo.bar.baz'),
            3 => new AutocompleteItem(value: 'foo.qux'),
            4 => new AutocompleteItem(value: 'foo.quux'),
            5 => new AutocompleteItem(value: 'foo.quux.corge'),
            6 => new AutocompleteItem(value: 'foo.quux.grault'),
            7 =>new AutocompleteItem(value:  'garply'),
            8 =>new AutocompleteItem(value:  'garply.waldo'),
        ], $builder->buildWords());
    }

    public function testSeparator(): void
    {
        $autocomplete = [
            "foo" => [
                "bar" => [
                    "baz" => true,
                ],
            ],
        ];
        $builder = new AutocompleteTreeBuilder($autocomplete, "->");
        $this->assertEquals([
            new AutocompleteItem(value:  "foo"),
            new AutocompleteItem(value: "foo->bar"),
            new AutocompleteItem(value: "foo->bar->baz"),
        ], $builder->buildWords());
    }
}
