<?php

namespace Blacktrs\DataTransformer\Serializer;

interface ItemSerializerInterface
{
    public function __construct(object $item);

    public function value(): mixed;
}
