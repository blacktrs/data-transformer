<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Attribute;

use Attribute;
use Blacktrs\DataTransformer\Transformer\{ObjectTransformerInterface};
use Blacktrs\DataTransformer\ValueResolverInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
class TransformerField
{
    public function __construct(
        public readonly ?string $nameIn = null,
        public readonly ?string $nameOut = null,

        /**
         * @var ValueResolverInterface|class-string<ValueResolverInterface>|null $valueTransformer
         */
        public readonly ValueResolverInterface|string|null $valueResolver = null,

        /**
         * @var ObjectTransformerInterface|class-string<ObjectTransformerInterface>|null $objectTransformer
         */
        public readonly ObjectTransformerInterface|string|null $objectTransformer = null,
        public readonly bool $ignoreTransform = false,
        public readonly bool $ignoreSerialize = false
    ) {
    }
}
