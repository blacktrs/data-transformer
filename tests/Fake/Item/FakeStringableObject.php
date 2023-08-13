<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

class FakeStringableObject
{
    public function __construct(private int $value)
    {
    }

    public function __toString(): string
    {
        return 'String value: '. $this->value;
    }
}
