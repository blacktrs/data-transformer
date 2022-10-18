<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use ReflectionProperty;

trait Fieldable
{
    private function getFieldAttribute(ReflectionProperty $property): TransformerField
    {
        $attribute = $property->getAttributes(TransformerField::class)[0] ?? null;

        if ($attribute === null) {
            return new TransformerField(ignoreTransform: !$property->isPublic(), ignoreSerialize: !$property->isPublic());
        }

        return $attribute->newInstance();
    }
}
