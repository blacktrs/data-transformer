<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use Blacktrs\DataTransformer\{Fieldable, ValueResolverInterface};
use ReflectionProperty;

class ArrayObjectSerializer implements ObjectSerializerInterface
{
    use Fieldable;

    /**
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $originSerializer
     * @return array<array-key, mixed>
     */
    public function serialize(object $object, ObjectSerializerInterface|string|null $originSerializer = null): array
    {
        $reflection = new \ReflectionClass($object);
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

        return \is_string($serializer) ? new $serializer() : $serializer;
    }

    private function getFieldValue(
        TransformerField $field,
        ReflectionProperty $property,
        object $object,
        ?ObjectSerializerInterface $originSerializer
    ): mixed {
        $value = $this->getValueFromMethods($object, $property);

        if ($field->valueResolver !== null && is_subclass_of($field->valueResolver, ValueResolverInterface::class)) {
            $serializer = \is_string($field->valueResolver) ? new $field->valueResolver() : $field->valueResolver;

            return  $serializer->serialize($value);
        }

        if (\is_object($value)) {
            if ($originSerializer) {
                return  $originSerializer->serialize($value);
            }

            return $this->serialize($value);
        }

        return $value;
    }

    private function getValueFromMethods(object $object, ReflectionProperty $property): mixed
    {
        if (\is_callable([$object, $property->getName()])) {
            $methodName = $property->getName();
            return $object->$methodName();
        }

        if (\is_callable([$object, 'get' . ucfirst($property->getName())])) {
            $methodName = 'get' . ucfirst($property->getName());
            return $object->$methodName();
        }

        return $property->getValue($object);
    }
}
