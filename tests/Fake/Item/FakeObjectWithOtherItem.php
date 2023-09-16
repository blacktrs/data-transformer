<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataField;
use Blacktrs\DataTransformer\Transformer\Transformer;

class FakeObjectWithOtherItem
{
    public string $objectId;

    #[DataField(nameIn: 'fake_simple_object', objectTransformer: new Transformer())]
    public FakeSimpleObject $simpleObject;
}
