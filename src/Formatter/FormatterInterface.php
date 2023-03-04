<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Formatter;

use Blacktrs\DataTransformer\Serializer\{CollectionSerializerInterface, ObjectSerializerInterface};

interface FormatterInterface
{
    public function format(ObjectSerializerInterface|CollectionSerializerInterface $serializer): mixed;
}
