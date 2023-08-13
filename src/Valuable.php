<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer;

use Blacktrs\DataTransformer\Attribute\DataField;
use Blacktrs\DataTransformer\Serializer\ObjectSerializerInterface;
use Blacktrs\DataTransformer\Value\ValueResolverInterface;
use ReflectionProperty;

use BackedEnum;
use UnitEnum;

use function is_callable;
use function is_object;
use function is_string;

trait Valuable
{
    private function getFieldValue(
        DataField $field,
        ReflectionProperty $property,
        object $object,
        ?ObjectSerializerInterface $originSerializer
    ): mixed {
        $value = $this->getValueFromGetterMethod($object, $property);

        if ($field->valueResolver !== null && is_subclass_of($field->valueResolver, ValueResolverInterface::class)) {
            $serializer = is_string($field->valueResolver) ? new $field->valueResolver() : $field->valueResolver;

            return $serializer->serialize($value, $field->valueResolverArguments);
        }

        if ($value instanceof BackedEnum) {
            return $value->value;
        }

        if ($value instanceof UnitEnum) {
            return $value->name;
        }

        if (is_object($value)) {
            if (is_callable([$value, '__toString'])) {
                return (string) $value;
            }

            return $originSerializer ? $originSerializer->serialize($value) : $this->serialize($value);
        }

        return $value;
    }

    private function getValueFromGetterMethod(object $object, ReflectionProperty $property): mixed
    {
        if (is_callable([$object, $property->getName()])) {
            $methodName = $property->getName();
            return $object->$methodName();
        }

        $getterMethodName = 'get' . ucfirst($property->getName());
        if (is_callable([$object, $getterMethodName])) {
            return $object->$getterMethodName();
        }

        return $property->getValue($object);
    }
}
