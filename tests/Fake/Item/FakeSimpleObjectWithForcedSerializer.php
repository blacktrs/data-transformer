<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataObject;
use Blacktrs\DataTransformer\Serializer\Serializer\JsonSerializer;

#[DataObject(serializer: JsonSerializer::class)]
class FakeSimpleObjectWithForcedSerializer
{
    public int $id;

    public string $label;

    public ?string $context;
}
