<?php

namespace Blacktrs\DataTransformer\Attribute;

use Attribute;
use Blacktrs\DataTransformer\Serializer\FieldSerializerInterface;
use Blacktrs\DataTransformer\Transformer\{ObjectTransformerInterface, ValueTransformerInterface};

#[Attribute(Attribute::TARGET_PROPERTY)]
class Field
{
    public function __construct(
        public readonly ?string $nameIn = null,
        public readonly ?string $nameOut = null,

        /**
         * @var ValueTransformerInterface|class-string<ValueTransformerInterface>|null $valueTransformer
         */
        public readonly ValueTransformerInterface|string|null $valueTransformer = null,

        /**
         * @var ObjectTransformerInterface|class-string<ObjectTransformerInterface>|null $objectTransformer
         */
        public readonly ObjectTransformerInterface|string|null $objectTransformer = null,
        public readonly bool $ignoreTransform = false,
        public readonly bool $ignoreSerialize = false,

        /**
         * @var FieldSerializerInterface|class-string<FieldSerializerInterface>|null $objectTransformer
         */
        public readonly FieldSerializerInterface|string|null $serializer = null
    ) {
    }
}
