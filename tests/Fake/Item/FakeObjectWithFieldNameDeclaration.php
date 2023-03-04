<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataField;

class FakeObjectWithFieldNameDeclaration
{
    #[DataField(nameIn: 'origin_name')]
    public readonly string $customName;
}
