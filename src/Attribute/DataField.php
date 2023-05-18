<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Attribute;

use Attribute;
use Blacktrs\DataTransformer\Transformer\{TransformerInterface};
use Blacktrs\DataTransformer\Value\ValueResolverInterface;

#[Attribute(Attribute::TARGET_PROPERTY)]
readonly class DataField
{
    public function __construct(
        public ?string $nameIn = null,
        public ?string $nameOut = null,

        /**
         * @var ValueResolverInterface|class-string<ValueResolverInterface>|null $valueTransformer
         */
        public ValueResolverInterface|string|null $valueResolver = null,
        /**
         * @var array<mixed>
         */
        public array $valueResolverArguments = [],

        /**
         * @var TransformerInterface|class-string<TransformerInterface>|null $objectTransformer
         */
        public TransformerInterface|string|null $objectTransformer = null,
        public bool $ignoreTransform = false,
        public bool $ignoreSerialize = false
    ) {
    }
}
