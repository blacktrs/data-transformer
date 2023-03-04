<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

interface ObjectSerializerInterface
{
    public function serialize(object $object, ObjectSerializerInterface|string|null $originSerializer = null): mixed;
}
