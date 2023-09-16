<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Transformer;

interface TransformerInterface
{
    /**
     * @param class-string $object
     * @param array<array<array-key, mixed>>|array<array-key, mixed> $data
     */
    public function transform(string $object, iterable $data): mixed;
}
