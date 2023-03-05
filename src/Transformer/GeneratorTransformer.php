<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Transformer;

use Generator;

class GeneratorTransformer implements CollectionTransformerInterface
{
    /**
     * @param class-string $objectClass
     * @param array<array-key, array<array-key, mixed>> $data
     * @param TransformerInterface|null $transformer
     * @return Generator<object>
     */
    public function transform(string $objectClass, iterable $data, ?TransformerInterface $transformer = null): Generator
    {
        $objectTransformer = new Transformer();

        foreach ($data as $item) {
            yield $objectTransformer->transform($objectClass, $item);
        }
    }
}
