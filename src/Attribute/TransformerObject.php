<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Attribute;

use Attribute;
use Blacktrs\DataTransformer\Serializer\ObjectSerializerInterface;

#[Attribute(Attribute::TARGET_CLASS)]
class TransformerObject
{
    public function __construct(
        /**
         * @var ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $objectTransformer
         */
        public readonly ObjectSerializerInterface|string|null $serializer = null
    ) {
    }
}
