<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

interface CollectionSerializerInterface
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
    ): iterable;
}
