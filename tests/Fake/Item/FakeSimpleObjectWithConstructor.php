<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;

class FakeSimpleObjectWithConstructor
{
    public function __construct(
        #[TransformerField]
        public readonly int $id,
        #[TransformerField]
        public readonly string $label,
    ) {
    }
}
