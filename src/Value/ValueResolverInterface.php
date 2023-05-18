<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Value;

interface ValueResolverInterface
{
    /**
     * @param array<mixed> $arguments
     */
    public function transform(mixed $value, array $arguments): mixed;

    /**
     * @param array<mixed> $arguments
     */
    public function serialize(mixed $value, array $arguments): mixed;
}
