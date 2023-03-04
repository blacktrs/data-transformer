<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer\Serializer;

/**
 * @description The wrapper for converting the object collection to an array data collection
 */

use Blacktrs\DataTransformer\Serializer\{CollectionSerializerInterface, ObjectSerializerInterface};

class CollectionSerializer implements CollectionSerializerInterface
{
    /**
     * @param iterable<object> $objects
     * @param iterable<mixed>|null $collection
     * @return iterable<array<array-key, mixed>>
     */
    public function serialize(
        iterable $objects,
        ?iterable $collection = null,
        ObjectSerializerInterface|string|null $serializer = null
    ): iterable {
        $serializer ??= new ArraySerializer();
        $collection ??= [];

        foreach ($objects as $object) {
            $collection[] = $serializer->serialize($object);
        }

        return $collection;
    }
}
