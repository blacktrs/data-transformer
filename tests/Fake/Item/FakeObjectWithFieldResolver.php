<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use Blacktrs\DataTransformer\Tests\Fake\Field\FakeDateTimeValueResolver;

class FakeObjectWithFieldResolver
{
    #[TransformerField(valueResolver: FakeDateTimeValueResolver::class)]
    public \DateTime $dateTime;
}
