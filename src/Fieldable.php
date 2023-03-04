<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer;

use Blacktrs\DataTransformer\Attribute\DataField;
use ReflectionProperty;

trait Fieldable
{
    private function getFieldAttribute(ReflectionProperty $property): DataField
    {
        $attribute = $property->getAttributes(DataField::class)[0] ?? null;

        if ($attribute === null) {
            return new DataField(ignoreTransform: !$property->isPublic(), ignoreSerialize: !$property->isPublic());
        }

        return $attribute->newInstance();
    }
}
