<?php

namespace Blacktrs\DataTransformer\Serializer;

class ArrayCollectionSerializer
{
    public function serialize(iterable $objects): iterable
    {
        $serializer = new ArrayObjectSerializer();
        $collection = [];

        foreach ($objects as $object) {
            $collection[] = $serializer->serialize($object);
        }

        return $collection;
    }
}
