<?php

namespace Blacktrs\DataTransformer\Attribute;

use Blacktrs\DataTransformer\Serializer\ObjectSerializerInterface;

#[\Attribute(\Attribute::TARGET_CLASS)]
class TransformerItem
{
    public function __construct(
        /**
         * @var ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $objectTransformer
         */
        public readonly ObjectSerializerInterface|string|null $serializer = null
    ) {
    }
}
