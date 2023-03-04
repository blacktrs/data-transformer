<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\RandomUserApi;

use Blacktrs\DataTransformer\Attribute\DataField;

class RandomUser
{
    #[DataField]
    public readonly Name $name;
}
