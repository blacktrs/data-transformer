<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\RandomUserApi;

use Blacktrs\DataTransformer\Attribute\DataField;

readonly class Name
{
    public string $title;

    #[DataField(nameIn: 'first')]
    public string $firstName;

    #[DataField(nameIn: 'last')]
    public string $lastName;
}
