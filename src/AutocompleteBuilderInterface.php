<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Jozef Môstka
 * Date: 30. 12. 2024
 * Time: 21:21
 */

namespace AceEditorBundle;

interface AutocompleteBuilderInterface
{
    /** @return iterable<AutocompleteItem> */
    public function buildWords(): iterable;
}
