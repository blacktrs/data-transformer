<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\RandomUserApi;

use Blacktrs\DataTransformer\Attribute\TransformerField;

class RandomUser
{
    #[TransformerField]
    public readonly Name $name;
}
