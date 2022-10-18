<?php

namespace Blacktrs\DataTransformer\Tests\Fake\Item\Transform;

use Blacktrs\DataTransformer\Attribute\Field;

class FakeObjectWithFieldNameDeclaration
{
    #[Field(nameIn: 'camel_cased_name')]
    public readonly string $camelCasedName;
}
