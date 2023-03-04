<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

use Blacktrs\DataTransformer\Attribute\TransformerObject;
use ReflectionClass;

use function is_string;

/*
 * Basic wrapper for converting an object to an array
 */
class ObjectSerializer implements ObjectSerializerInterface
{
    public function serialize(object $object, ObjectSerializerInterface|string|null $originSerializer = null): mixed
    {
        $reflection = new ReflectionClass($object);
        $objectItem = $this->getTransformerObject($reflection);

        return $this->getObjectSerializer($objectItem)->serialize($object, $this);
    }

    private function getObjectSerializer(TransformerObject $objectItem): ObjectSerializerInterface
    {
        if ($objectItem->serializer === null) {
            return new ArrayObjectSerializer();
        }

        return is_string($objectItem->serializer) ? new $objectItem->serializer() : $objectItem->serializer;
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function getTransformerObject(ReflectionClass $reflection): TransformerObject
    {
        $objectItem = $reflection->getAttributes(TransformerObject::class)[0] ?? null;

        if ($objectItem === null) {
            return new TransformerObject();
        }

        return $objectItem->newInstance();
    }
}
