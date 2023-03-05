<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

use ArrayAccess;
use Blacktrs\DataTransformer\Serializer\Serializer\ArraySerializer;

use Generator;
use Traversable;

use function is_string;

/**
 * @description Basic implementation for converting data object to generator values
 */
class GeneratorSerializer implements CollectionSerializerInterface
{
    /**
     * @param iterable<object> $objects
     * @param (ArrayAccess<array-key,mixed>&Traversable<array-key,mixed>)|array<array-key, mixed>|null $collection
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $serializer
     */
    public function serialize(
        iterable $objects,
        (ArrayAccess&Traversable)|array|null $collection = null,
        ObjectSerializerInterface|string|null $serializer = null
    ): Generator {
        $serializerInstance = $this->getSerializerInstance($serializer);

        foreach ($objects as $object) {
            yield $serializerInstance->serialize($object);
        }
    }

    /**
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $serializer
     */
    private function getSerializerInstance(ObjectSerializerInterface|string|null $serializer): ObjectSerializerInterface
    {
        if ($serializer === null) {
            return new ArraySerializer();
        }

        return is_string($serializer) ? new $serializer() : $serializer;
    }
}
