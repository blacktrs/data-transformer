<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataField;
use Blacktrs\DataTransformer\Value\DateTimeValueResolver;
use DateTime;

class FakeObjectWithFieldResolver
{
    #[DataField(valueResolver: DateTimeValueResolver::class)]
    public DateTime $dateTime;
}
