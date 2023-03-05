<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Value;

use DateTime;

class DateTimeValueResolver implements ValueResolverInterface
{
    public function transform(mixed $value, ...$arguments): DateTime
    {
        return new DateTime($value);
    }

    /**
     * @param DateTime $value
     */
    public function serialize(mixed $value, ...$arguments): string
    {
        $format = $arguments['format'] ?? DATE_ATOM;

        return $value->format($format);
    }
}
