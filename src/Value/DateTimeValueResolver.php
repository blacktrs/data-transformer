<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Value;

use DateTime;

class DateTimeValueResolver implements ValueResolverInterface
{
    /**
     * @param array<mixed> $arguments
     */
    public function transform(mixed $value, array $arguments): DateTime
    {
        return new DateTime($value);
    }

    /**
     * @param DateTime $value
     * @param array<mixed> $arguments
     */
    public function serialize(mixed $value, array $arguments): string
    {
        $format = $arguments['format'] ?? DATE_ATOM;

        return $value->format($format);
    }
}
