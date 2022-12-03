<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Transformer;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use Blacktrs\DataTransformer\{Fieldable, ValueResolverInterface};
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

use function array_key_exists;
use function is_string;

class ObjectTransformer implements ObjectTransformerInterface
{
    use Fieldable;

    /**
     * @var array<array-key, mixed>
     */
    private array $data;

    private object $object;

    /**
     * @param class-string $objectClass
     * @param array<array-key, mixed> $data
     */
    public function transform(string $objectClass, iterable $data): object
    {
        $this->data = $data;
        $this->object = new $objectClass();

        $this->handleItem();

        return $this->object;
    }

    private function handleItem(): void
    {
        $reflection = new ReflectionClass($this->object);

        $properties = $reflection->getProperties();

        foreach ($properties as $property) {
            $field = $this->getFieldAttribute($property);

            if (!$this->isPropertyWritable($property, $field)) {
                continue;
            }

            $name = $field->nameIn ?? $property->getName();

            if (array_key_exists($name, $this->data)) {
                $property->setAccessible(true);
                $value = $this->getValue($field, $property, $name);

                $property->setValue($this->object, $value);
            }
        }
    }

    private function isPropertyWritable(ReflectionProperty $property, TransformerField $field): bool
    {
        if ($property->isReadOnly()) {
            return !$field->ignoreTransform && !$property->isInitialized($this->object);
        }

        return !$field->ignoreTransform;
    }

    private function getValue(TransformerField $field, ReflectionProperty $property, string $name): mixed
    {
        /** @var ReflectionNamedType|ReflectionIntersectionType|ReflectionUnionType $reflectionType */
        $reflectionType = $property->getType();

        if (
            $field->valueResolver !== null
            && is_subclass_of($field->valueResolver, ValueResolverInterface::class)
        ) {
            /** @var ValueResolverInterface $valueTransformer */
            $valueTransformer = is_string($field->valueResolver) ? new $field->valueResolver() : $field->valueResolver;

            return $valueTransformer->transform($this->data[$name]);
        }

        if (
            $field->objectTransformer !== null
            && is_subclass_of($field->objectTransformer, ObjectTransformerInterface::class)
            && $property->hasType()
        ) {
            /** @var ObjectTransformerInterface $objectTransformer */
            $objectTransformer = is_string($field->objectTransformer) ? new $field->objectTransformer() : $field->objectTransformer;

            /** @var class-string $objectClass */
            $objectClass = $this->getType($reflectionType);

            return $objectTransformer->transform($objectClass, $this->data[$name]);
        }

        $value = $this->data[$name];

        if ($property->hasType() && $reflectionType instanceof ReflectionNamedType) {
            if ($reflectionType->isBuiltin()) {
                settype($value, $reflectionType->getName());

                return $value;
            }

            if (class_exists($reflectionType->getName())) {
                return (new self())->transform($reflectionType->getName(), $value);
            }
        }

        return $value;
    }

    /**
     * @return class-string|string
     */
    private function getType(ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType $type): string
    {
        /** @psalm-suppress UndefinedMethod */
        return match (true) {
            $type instanceof ReflectionNamedType => $type->getName(),
            $type instanceof ReflectionUnionType, $type instanceof ReflectionIntersectionType => $type->getTypes()[0]->getName()
        };
    }
}
