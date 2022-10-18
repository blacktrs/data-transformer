<?php

namespace Blacktrs\DataTransformer\Tests\Fake\RandomUserApi;

use Blacktrs\DataTransformer\Attribute\TransformerField;

class RandomUser
{
    #[TransformerField]
    public readonly Name $name;
}