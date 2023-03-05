<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataField;
use Blacktrs\DataTransformer\Value\DateTimeValueResolver;
use DateTime;

class FakeObjectWithFieldResolverAndArguments
{
    #[DataField(valueResolver: DateTimeValueResolver::class, valueResolverArguments: ['format' => DATE_RFC7231])]
    public DateTime $dateTime;
}
