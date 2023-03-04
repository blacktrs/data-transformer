<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Attribute;

use Attribute;
use Blacktrs\DataTransformer\Serializer\ObjectSerializerInterface;

#[Attribute(Attribute::TARGET_CLASS)]
readonly class DataObject
{
    public function __construct(
        /**
         * @var ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $objectTransformer
         */
        public ObjectSerializerInterface|string|null $serializer = null
    ) {
    }
}
