<?php

declare(strict_types=1);

namespace AceEditorBundle;

readonly class AutocompleteItem implements \JsonSerializable
{
    public function __construct(
        public string $value,
        public ?string $meta = null,
        public int $score = 1
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'value' => $this->value,
            'meta'  => $this->meta,
            'score' => $this->score,
        ];
    }
}
