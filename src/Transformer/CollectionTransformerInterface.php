<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Transformer;

interface CollectionTransformerInterface
{
    /**
     * @param class-string $objectClass
     * @param array<array-key, array<array-key, mixed>> $data
     * @param TransformerInterface|null $transformer
     * @return iterable<object>
     */
    public function transform(string $objectClass, iterable $data, ?TransformerInterface $transformer = null): iterable;
}
