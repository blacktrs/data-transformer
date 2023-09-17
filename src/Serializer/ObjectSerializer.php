<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Serializer;

use Blacktrs\DataTransformer\Attribute\DataObject;
use Blacktrs\DataTransformer\Serializer\Serializer\ArraySerializer;
use ReflectionClass;

use function is_string;

/**
 * @description Basic wrapper for converting an object to an array
 */
class ObjectSerializer implements ObjectSerializerInterface
{
    public function __construct(private bool $includePrivateProperties = false)
    {
    }

    public function serialize(object $object, ObjectSerializerInterface|string|null $originSerializer = null): mixed
    {
        $reflection = new ReflectionClass($object);
        $objectItem = $this->getTransformerObject($reflection);

        return $this->getObjectSerializer($objectItem, $originSerializer)
            ->setIncludePrivateProperties($this->includePrivateProperties)
            ->serialize($object, $this);
    }

    public function setIncludePrivateProperties(bool $includePrivateProperties): self
    {
        $this->includePrivateProperties = $includePrivateProperties;

        return $this;
    }

    private function getObjectSerializer(
        DataObject $objectItem,
        ObjectSerializerInterface|string|null $originSerializer
    ): ObjectSerializerInterface {
        /** @var ObjectSerializerInterface|class-string<ObjectSerializerInterface> $serializer */
        $serializer = $objectItem->serializer ?? $originSerializer ?? new ArraySerializer();

        return is_string($serializer) ? new $serializer() : $serializer;
    }

    /**
     * @param ReflectionClass<object> $reflection
     */
    private function getTransformerObject(ReflectionClass $reflection): DataObject
    {
        $objectItem = $reflection->getAttributes(DataObject::class)[0] ?? null;

        if ($objectItem === null) {
            return new DataObject();
        }

        return $objectItem->newInstance();
    }
}
