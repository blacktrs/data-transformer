<?php

namespace Blacktrs\DataTransformer\Tests\Fake\Field;

use Blacktrs\DataTransformer\Transformer\ValueTransformerInterface;

class FakeDateTimeValueTransformer implements ValueTransformerInterface
{
    public function value(mixed $value): \DateTime
    {
        return new \DateTime($value);
    }
}
