<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use Blacktrs\DataTransformer\Value\DateTimeValueResolver;
use DateTime;

class FakeObjectWithFieldResolver
{
    #[TransformerField(valueResolver: DateTimeValueResolver::class)]
    public DateTime $dateTime;
}
