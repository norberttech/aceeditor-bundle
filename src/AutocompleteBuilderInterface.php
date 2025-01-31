<?php

declare(strict_types=1);

namespace AceEditorBundle;

interface AutocompleteBuilderInterface
{
    /** @return iterable<AutocompleteItem> */
    public function buildWords(): iterable;
}
