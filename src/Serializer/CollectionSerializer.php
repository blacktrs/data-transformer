<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

/**
 * @description The wrapper for converting the object collection to an array data collection
 */

use ArrayAccess;
use Blacktrs\DataTransformer\Serializer\{Serializer\ArraySerializer};
use Traversable;

use function is_string;

class CollectionSerializer implements CollectionSerializerInterface
{
    /**
     * @param iterable<object> $objects
     * @param (ArrayAccess<array-key,mixed>&Traversable<array-key,mixed>)|array<array-key, mixed>|null $collection
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $serializer
     * @return (ArrayAccess<int, mixed>&Traversable<int,mixed>)|array<int, mixed>
     */
    public function serialize(
        iterable $objects,
        (ArrayAccess&Traversable)|array|null $collection = null,
        ObjectSerializerInterface|string|null $serializer = null
    ): iterable {
        if (empty($objects)) {
            return [];
        }

        $serializerInstance = $this->getSerializerInstance($serializer);
        $collection ??= [];

        foreach ($objects as $object) {
            $collection[] = $serializerInstance->serialize($object);
        }

        return $collection;
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
