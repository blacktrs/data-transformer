<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use Blacktrs\DataTransformer\Transformer\Transformer;

class FakeObjectWithOtherItem
{
    #[TransformerField]
    public string $objectId;

    #[TransformerField(nameIn: 'fake_simple_object', objectTransformer: new Transformer())]
    public FakeSimpleObject $simpleObject;
}
