<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;

class FakeObjectWithGetters
{
    public function __construct(
        #[TransformerField]
        private readonly string $name,
        #[TransformerField]
        public readonly int $age,
        #[TransformerField]
        private readonly bool $isHuman
    ) {
    }

    public function getName(): string
    {
        return $this->name.'1';
    }

    public function isHuman(): bool
    {
        return true;
    }
}
