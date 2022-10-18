<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

class ArrayCollectionSerializer
{
    /**
     * @param iterable<object> $objects
     * @return array<array<array-key, mixed>>
     */
    public function serialize(iterable $objects): array
    {
        $serializer = new ArrayObjectSerializer();
        $collection = [];

        foreach ($objects as $object) {
            $collection[] = $serializer->serialize($object);
        }

        return $collection;
    }
}
