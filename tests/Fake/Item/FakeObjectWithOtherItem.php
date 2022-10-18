<?php

namespace Blacktrs\DataTransformer\Tests\Fake\Item\Transform;

use Blacktrs\DataTransformer\Attribute\Field;
use Blacktrs\DataTransformer\Transformer\ObjectTransformer;

class FakeObjectWithOtherItem
{
    public string $objectId;

    #[Field(nameIn: 'fake_simple_object', objectTransformer: ObjectTransformer::class)]
    public FakeSimpleObject $simpleObject;
}
