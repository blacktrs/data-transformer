<?php

namespace Blacktrs\DataTransformer\Item;

interface ItemTransformerInterface
{
    /**
     * @param class-string $objectClass
     * @param array<array-key, mixed> $data
     */
    public function __construct(string $objectClass, array $data);

    public function value(): mixed;
}
