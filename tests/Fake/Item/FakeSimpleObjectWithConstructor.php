<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataField;

class FakeSimpleObjectWithConstructor
{
    public function __construct(
        public readonly int $id,
        public readonly string $label,
        #[DataField(ignoreSerialize: true)]
        public readonly bool $hidden = true
    ) {
    }
}
