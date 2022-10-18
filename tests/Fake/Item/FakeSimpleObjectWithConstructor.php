<?php

namespace Blacktrs\DataTransformer\Tests\Fake\Item\Serialize;

class FakeSimpleObject
{
    public function __construct(
        public readonly int $id,
        public readonly string $label,
    ) {
    }
}
