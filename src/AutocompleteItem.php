<?php

declare(strict_types=1);

namespace AceEditorBundle;

class AutocompleteItem implements \JsonSerializable
{
    public function __construct(
        public readonly string $value,
        public readonly ?string $meta = null,
        public readonly int $score = 1
    ) {}

    public function jsonSerialize(): mixed
    {
        return [
            'value' => $this->value,
            'meta'  => $this->meta,
            'score' => $this->score,
        ];
    }
}
