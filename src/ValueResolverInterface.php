<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer;

interface ValueResolverInterface
{
    public function transform(mixed $value): mixed;

    public function serialize(mixed $value): mixed;
}
