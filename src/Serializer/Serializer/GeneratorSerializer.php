<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer\Serializer;

use Blacktrs\DataTransformer\Serializer\ObjectSerializerInterface;
use Blacktrs\DataTransformer\{Fieldable, Valuable};
use Generator;
use ReflectionClass;

use function is_string;

/**
 * @description Basic implementation for converting data object to generator values
 */
class GeneratorSerializer implements ObjectSerializerInterface
{
    use Fieldable;
    use Valuable;

    /**
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $originSerializer
     * @return Generator<array-key, mixed>
     */
    public function serialize(object $object, string|ObjectSerializerInterface|null $originSerializer = null): Generator
    {
        $reflection = new ReflectionClass($object);
        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $field = $this->getFieldAttribute($property);

            if ($field->ignoreSerialize) {
                continue;
            }

            $name = $field->nameOut ?? $property->getName();
            yield $name => $this->getFieldValue($field, $property, $object, $this->getSerializer($originSerializer));
        }
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
