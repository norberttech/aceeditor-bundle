<?php

declare(strict_types=1);

namespace AceEditorBundle;

final class AutocompleteTreeBuilder implements AutocompleteBuilderInterface
{
    public function __construct(
        /** @var array<mixed> */
        private readonly array $tree,
        private string $separator = '.'
    ) {}

    /** @return iterable<AutocompleteItem> */
    public function buildWords(): iterable
    {
        return $this->populateAutocompleteTree($this->tree, '');
    }

    /**
     * @param array<mixed> $tree
     *
     * @return AutocompleteItem[]
     */
    private function populateAutocompleteTree(array $tree, string $path): array
    {
        $autocompleteWords = [];
        if ($path) {
            $autocompleteWords[] = new AutocompleteItem(value: $path);
        }
        if ($path) {
            $path .= $this->separator;
        }
        foreach ($tree as $key => $value) {
            if (\is_array($value)) {
                $autocompleteWords = array_merge(
                    $autocompleteWords,
                    $this->populateAutocompleteTree($value, $path . $key)
                );
            } elseif (\is_string($value)) {
                $autocompleteWords[] = new AutocompleteItem(value: $path . $value);
            } else {
                $autocompleteWords[] = new AutocompleteItem(value: $path . $key);
            }
        }

        return $autocompleteWords;
    }
}
