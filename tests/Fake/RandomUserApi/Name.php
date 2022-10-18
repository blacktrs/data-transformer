<?php

namespace Blacktrs\DataTransformer\Tests\Fake\RandomUserApi;

use Blacktrs\DataTransformer\Attribute\TransformerField;

class Name
{
    #[TransformerField]
    public readonly string $title;

    #[TransformerField(nameIn: 'first')]
    public readonly string $firstName;

    #[TransformerField(nameIn: 'last')]
    public readonly string $lastName;
}