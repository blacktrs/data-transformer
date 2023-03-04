<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\RandomUserApi;

use Blacktrs\DataTransformer\Attribute\DataField;

class Name
{
    #[DataField]
    public readonly string $title;

    #[DataField(nameIn: 'first')]
    public readonly string $firstName;

    #[DataField(nameIn: 'last')]
    public readonly string $lastName;
}
