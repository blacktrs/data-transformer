<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Value;

interface ValueResolverInterface
{
    public function transform(mixed $value, ...$arguments): mixed;

    public function serialize(mixed $value, ...$arguments): mixed;
}
