<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer\Serializer;

use Blacktrs\DataTransformer\{Fieldable, Serializer\ObjectSerializerInterface, Valuable};
use ReflectionClass;

use function is_string;

/**
 * @description Basic implementation for converting an object to an array
 */
class ArraySerializer implements ObjectSerializerInterface
{
    use Fieldable;
    use Valuable;

    private bool $includePrivateProperties = false;

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
            $field = $this->getPropertyAttribute($property);

            if (!$this->includePrivateProperties && $field->ignoreSerialize) {
                continue;
            }

            $name = $field->nameOut ?? $property->getName();
            $serialized[$name] = $this->getFieldValue($field, $property, $object, $this->getSerializer($originSerializer));
        }

        return $serialized;
    }

    public function setIncludePrivateProperties(bool $includePrivateProperties): self
    {
        $this->includePrivateProperties = $includePrivateProperties;

        return $this;
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
}
