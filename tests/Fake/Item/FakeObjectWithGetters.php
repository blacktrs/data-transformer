<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataField;

class FakeObjectWithGetters
{
    public function __construct(
        #[DataField]
        private readonly string $name,
        #[DataField]
        public readonly int $age,
        #[DataField]
        private bool $isHuman
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
