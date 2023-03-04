<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataField;

class FakeSimpleObjectWithConstructor
{
    public function __construct(
        #[DataField]
        public readonly int $id,
        #[DataField]
        public readonly string $label,
    ) {
    }
}
