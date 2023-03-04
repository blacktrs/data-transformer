<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

use ArrayAccess;
use Traversable;

interface CollectionSerializerInterface
{
    /**
     * @param iterable<object> $objects
     * @param (ArrayAccess<array-key, mixed>&Traversable<array-key, mixed>)|array<array-key, mixed>|null $collection
     * @return (ArrayAccess<array-key, mixed>&Traversable<array-key, mixed>)|array<array-key, mixed>
     */
    public function serialize(
        iterable $objects,
        (ArrayAccess&Traversable)|array|null $collection = null,
        ObjectSerializerInterface|string|null $serializer = null
    ): iterable;
}
