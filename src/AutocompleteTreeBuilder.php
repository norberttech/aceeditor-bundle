<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Jozef Môstka
 * Date: 30. 12. 2024
 * Time: 21:18
 */

namespace AceEditorBundle;

final class AutocompleteTreeBuilder implements AutocompleteBuilderInterface
{
    public function __construct(
        /** @var array<mixed> */
        private readonly array $tree,
        private string $separator = '.'
    ) {
    }

    /** @return iterable */
    public function buildWords(): iterable
    {
        return $this->populateAutocompleteTree($this->tree, "");
    }

    /**
     * @param array<mixed> $tree
     * @param string $path
     * @return AutocompleteItem[]
     */
    private function populateAutocompleteTree(array $tree, string $path): array
    {
        $autocompleteWorlds = [ ];
        if ($path) {
            $autocompleteWorlds[] = new AutocompleteItem(value:$path);
        }
        if ($path) {
            $path .= $this->separator;
        }
        foreach ($tree as $key => $value) {
            if (is_array($value)) {
                $autocompleteWorlds = array_merge(
                    $autocompleteWorlds,
                    $this->populateAutocompleteTree($value, $path . $key)
                );
            } elseif (is_string($value)) {
                $autocompleteWorlds[] = new AutocompleteItem(value:$path  . $value);
            } else {
                $autocompleteWorlds[] = new AutocompleteItem(value:$path. $key);
            }
        }

        return $autocompleteWorlds;
    }
}
