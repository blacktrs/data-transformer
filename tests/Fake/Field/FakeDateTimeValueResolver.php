<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Field;

use Blacktrs\DataTransformer\ValueResolverInterface;
use DateTime;

class FakeDateTimeValueResolver implements ValueResolverInterface
{
    public function transform(mixed $value): DateTime
    {
        return new DateTime($value);
    }

    /**
     * @param DateTime $value
     * @return string
     */
    public function serialize(mixed $value): string
    {
        return $value->format(DATE_ATOM);
    }
}
