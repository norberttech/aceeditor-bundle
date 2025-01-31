<?php

declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Jozef Môstka
 * Date: 24. 1. 2025
 * Time: 21:23
 */

namespace AceEditorBundle;

class AutocompleteItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $value,
        public readonly ?string $meta = null,
        public readonly int $score = 1
    ) {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'value' => $this->value,
            'meta' => $this->meta,
            'score' => $this->score,
        ];
    }
}
