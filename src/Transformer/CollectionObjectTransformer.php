<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Transformer;

/*
 * The wrapper for converting an array data collection to an object collection
 * Based on default transformer implementation
 */
class CollectionObjectTransformer
{
    /**
     * @param class-string $objectClass
     * @param array<array-key, array<array-key, mixed>> $data
     * @return iterable<object>
     */
    public function transform(string $objectClass, iterable $data): iterable
    {
        $objectTransformer = new ObjectTransformer();
        $collection = [];

        foreach ($data as $item) {
            $collection[] = $objectTransformer->transform($objectClass, $item);
        }

        return $collection;
    }
}
