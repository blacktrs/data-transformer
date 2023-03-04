<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use Blacktrs\DataTransformer\{Fieldable, ValueResolverInterface};
use ReflectionProperty;
use ReflectionClass;

use function is_string;
use function is_object;
use function is_callable;

/*
 * Basic implementation for converting an object to an array
 */
class ArrayObjectSerializer implements ObjectSerializerInterface
{
    use Fieldable;

    /**
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $originSerializer
     * @return array<array-key, mixed>
     */
    public function serialize(object $object, ObjectSerializerInterface|string|null $originSerializer = null): array
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        $serialized = [];
        foreach ($properties as $property) {
            $field = $this->getFieldAttribute($property);

            if ($field->ignoreSerialize) {
                continue;
            }

            $name = $field->nameOut ?? $property->getName();
            $serialized[$name] = $this->getFieldValue($field, $property, $object, $this->getSerializer($originSerializer));
        }

        return $serialized;
    }

    /**
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $serializer
     */
    private function getSerializer(ObjectSerializerInterface|string|null $serializer): ?ObjectSerializerInterface
    {
        if ($serializer === null) {
            return null;
        }

        return is_string($serializer) ? new $serializer() : $serializer;
    }

    private function getFieldValue(
        TransformerField $field,
        ReflectionProperty $property,
        object $object,
        ?ObjectSerializerInterface $originSerializer
    ): mixed {
        $value = $this->getValueFromGetterMethod($object, $property);

        if ($field->valueResolver !== null && is_subclass_of($field->valueResolver, ValueResolverInterface::class)) {
            $serializer = is_string($field->valueResolver) ? new $field->valueResolver() : $field->valueResolver;

            return $serializer->serialize($value);
        }

        if (is_object($value)) {
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
            $methodName = 'get' . $getterMethodName();
            return $object->$methodName();
        }

        return $property->getValue($object);
    }
}
