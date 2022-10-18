<?php

namespace Blacktrs\DataTransformer\Transformer;

interface ValueResolverInterface
{
    public function transform(mixed $value): mixed;

    public function serialize(mixed $value): mixed;
}
