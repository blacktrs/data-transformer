<?php

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use Blacktrs\DataTransformer\Tests\Fake\Field\FakeDateTimeValueResolver;

class FakeObjectWithFieldTransformer
{
    #[TransformerField(valueResolver: FakeDateTimeValueResolver::class)]
    public readonly \DateTime $dateTime;
}
