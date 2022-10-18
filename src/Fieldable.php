<?php

namespace Blacktrs\DataTransformer\Shared;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use ReflectionProperty;

trait Fieldable
{
    private function getFieldAttribute(ReflectionProperty $property): ?TransformerField
    {
        $attribute = $property->getAttributes(TransformerField::class)[0] ?? null;

        if (!$attribute) {
            return null;
        }

        return $attribute->newInstance();
    }
}
