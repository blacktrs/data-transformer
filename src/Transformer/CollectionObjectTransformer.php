<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Transformer;

/**
 * @description The wrapper for converting an array data collection to an object collection
 */
class CollectionObjectTransformer implements CollectionTransformerInterface
{
    /**
     * @param class-string $objectClass
     * @param array<array-key, array<array-key, mixed>> $data
     * @param TransformerInterface|null $transformer
     * @return iterable<object>
     */
    public function transform(string $objectClass, iterable $data, ?TransformerInterface $transformer = null): iterable
    {
        $objectTransformer = new Transformer();
        $collection = [];

        foreach ($data as $item) {
            $collection[] = $objectTransformer->transform($objectClass, $item);
        }

        return $collection;
    }
}
