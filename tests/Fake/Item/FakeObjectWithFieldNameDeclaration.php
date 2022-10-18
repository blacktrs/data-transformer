<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;

class FakeObjectWithFieldNameDeclaration
{
    #[TransformerField(nameIn: 'origin_name')]
    public readonly string $customName;
}
