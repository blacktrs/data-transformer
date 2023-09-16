<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer;

use Blacktrs\DataTransformer\Attribute\DataField;
use ReflectionProperty;
use ReflectionParameter;

trait Fieldable
{
    private function getPropertyAttribute(ReflectionProperty $property): DataField
    {
        $attribute = $property->getAttributes(DataField::class)[0] ?? null;

        if ($attribute === null) {
            return new DataField(ignoreTransform: !$property->isPublic(), ignoreSerialize: !$property->isPublic());
        }

        return $attribute->newInstance();
    }

    private function getParameterAttribute(ReflectionParameter $parameter): DataField
    {
        $attribute = $parameter->getAttributes(DataField::class)[0] ?? null;

        if ($attribute === null) {
            return new DataField(ignoreTransform: false, ignoreSerialize: false);
        }

        return $attribute->newInstance();
    }
}
