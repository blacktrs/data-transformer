<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

interface ObjectSerializerInterface
{
    /**
     * @param ObjectSerializerInterface|class-string<ObjectSerializerInterface>|null $originSerializer
     */
    public function serialize(object $object, ObjectSerializerInterface|string|null $originSerializer = null): mixed;

    public function setIncludePrivateProperties(bool $includePrivateProperties): self;
}
