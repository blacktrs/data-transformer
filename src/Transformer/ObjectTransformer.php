<?php

namespace Blacktrs\DataTransformer\Item;

use Blacktrs\DataTransformer\Attribute\Field;
use Blacktrs\DataTransformer\Value\ValueTransformerInterface;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionType;
use ReflectionUnionType;

class ItemTransformer implements ItemTransformerInterface
{
    private object $object;

    /**
     * {@inheritDoc}
     */
    public function __construct(string $objectClass, private readonly array $data)
    {
        $this->object = new $objectClass();

        $this->handleItem();
    }

    public function value(): object
    {
        return $this->object;
    }

    private function handleItem(): void
    {
        $reflection = new ReflectionClass($this->object);

        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $field = $this->getFieldAttribute($property);

            if ($field->ignore) {
                continue;
            }

            $name = $field->name ?? $property->getName();

            if (\array_key_exists($name, $this->data) && !$property->isInitialized($this->object)) {
                $property->setAccessible(true);
                $value = $this->getValue($field, $property, $name);

                $property->setValue($this->object, $value);
            }
        }
    }

    private function getFieldAttribute(ReflectionProperty $property): Field
    {
        $attribute = $property->getAttributes(Field::class)[0] ?? null;

        if (!$attribute) {
            return new Field();
        }

        return $attribute->newInstance();
    }

    private function getValue(Field $field, ReflectionProperty $property, string $name): mixed
    {
        $reflectionType = $property->getType();

        if ($field->valueTransformer !== null && is_subclass_of($field->valueTransformer, ValueTransformerInterface::class)) {
            /** @var ValueTransformerInterface $valueTransformer */
            $valueTransformer = new $field->valueTransformer($this->data[$name]);

            return $valueTransformer->value();
        }

        if (
            $field->itemTransformer !== null
            && is_subclass_of($field->itemTransformer, ItemTransformerInterface::class)
            && $property->hasType()
        ) {
            /** @var ItemTransformer $itemTransformer */
            $itemTransformer = new $field->itemTransformer($this->getType($reflectionType), $this->data[$name]);

            return $itemTransformer->value();
        }

        $value = $this->data[$name];

        if ($property->hasType() && $reflectionType->isBuiltin()) {
            $type = $this->getType($reflectionType);

            settype($value, $type);
        }

        return $value;
    }

    private function getType(?ReflectionType $reflectionType): string
    {
        return match (true) {
            $reflectionType instanceof ReflectionNamedType => $reflectionType->getName(),
            $reflectionType instanceof ReflectionUnionType,
            $reflectionType instanceof ReflectionIntersectionType => $reflectionType->getTypes()[0]->getName()
        };
    }
}
