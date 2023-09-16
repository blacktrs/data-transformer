<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Transformer;

use Blacktrs\DataTransformer\{Fieldable, Value\ValueResolverInterface};
use Blacktrs\DataTransformer\Attribute\DataField;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

use BackedEnum;
use UnitEnum;

use ReflectionParameter;

use function array_key_exists;
use function class_exists;
use function is_string;
use function settype;
use function is_object;

/*
 * Basic object transformer implementation
 * Using for converting array to target object
 */

class Transformer implements TransformerInterface
{
    use Fieldable;

    /**
     * @var array<array-key, mixed>
     */
    private array $data;

    public function __construct(private bool $includePrivateProperties = false)
    {
    }

    /**
     * @param class-string|object $object
     * @param array<array-key, mixed> $data
     */
    public function transform(string|object $object, iterable $data): object
    {
        $this->data = $data;
        $reflection = new ReflectionClass($object);
        $parameters = $reflection->getConstructor()?->getParameters();

        if (empty($parameters) || is_object($object)) {
            $object = is_string($object) ? new $object() : clone $object;
            $this->handleProperties($object, $reflection->getProperties());

            return $object;
        }

        $args = [];
        foreach ($parameters as $parameter) {
            $field = $this->getParameterAttribute($parameter);
            $name = $field->nameIn ?? $parameter->getName();

            if (array_key_exists($name, $this->data)) {
                $args[$name] = $this->getValue($field, $parameter, $name);
            }
        }

        $object = $reflection->newInstanceWithoutConstructor();
        $reflection->getConstructor()?->invokeArgs($object, $args);

        return $object;
    }

    public function setIncludePrivateProperties(bool $includePrivateProperties): Transformer
    {
        $this->includePrivateProperties = $includePrivateProperties;

        return $this;
    }

    /**
     * @param array<ReflectionProperty> $properties
     */
    private function handleProperties(object $object, array $properties): void
    {
        foreach ($properties as $property) {
            $field = $this->getPropertyAttribute($property);

            if (!$this->isPropertyWritable($property, $field, $object)) {
                continue;
            }

            $name = $field->nameIn ?? $property->getName();

            if (array_key_exists($name, $this->data)) {
                $value = $this->getValue($field, $property, $name);
                $property->setValue($object, $value);
            }
        }
    }

    private function isPropertyWritable(ReflectionProperty $property, DataField $field, object $object): bool
    {
        $isWriteable = $this->includePrivateProperties || !$field->ignoreTransform;

        if ($property->isReadOnly()) {
            return $isWriteable && !$property->isInitialized($object);
        }

        return $isWriteable;
    }

    private function getValue(DataField $field, ReflectionProperty|ReflectionParameter $property, string $name): mixed
    {
        /** @var ReflectionNamedType|ReflectionIntersectionType|ReflectionUnionType $reflectionType */
        $reflectionType = $property->getType();

        if ($this->fieldHasValueResolver($field)) {
            return $this->getValueFromValueResolver($field, $name, $field->valueResolverArguments);
        }

        if ($this->fieldHasObjectResolver($field, $property)) {
            return $this->getValueFromObjectResolver($field, $reflectionType, $name);
        }

        $value = $this->data[$name];

        if ($property->hasType() && $reflectionType instanceof ReflectionNamedType) {
            if ($reflectionType->isBuiltin()) {
                settype($value, $reflectionType->getName());

                return $value;
            }

            if (enum_exists($reflectionType->getName())) {
                /** @var class-string<UnitEnum>|class-string<BackedEnum> $enum */
                $enum = $reflectionType->getName();
                if (is_subclass_of($enum, BackedEnum::class)) {
                    return $enum::tryFrom($value);
                }

                $cases = array_values(array_filter($enum::cases(), fn (UnitEnum $unitEnum) => $unitEnum->name === $value));

                return $cases[0] ?? throw new TransformerException(sprintf('No enum case found for %s in %s', $value, $enum));
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
        /** @psalm-suppress PossiblyUndefinedMethod */
        return match (true) {
            $type instanceof ReflectionNamedType => $type->getName(),
            $type instanceof ReflectionUnionType, $type instanceof ReflectionIntersectionType => $type->getTypes()[0]->getName()
        };
    }

    private function fieldHasValueResolver(DataField $field): bool
    {
        return $field->valueResolver !== null
            && is_subclass_of($field->valueResolver, ValueResolverInterface::class);
    }

    private function fieldHasObjectResolver(DataField $field, ReflectionProperty|ReflectionParameter $property): bool
    {
        return $field->objectTransformer !== null
            && is_subclass_of($field->objectTransformer, TransformerInterface::class)
            && $property->hasType();
    }

    /**
     * @param array<mixed> $arguments
     */
    private function getValueFromValueResolver(DataField $field, string $name, array $arguments): mixed
    {
        /** @var ValueResolverInterface $valueTransformer */
        $valueTransformer = is_string($field->valueResolver) ? new $field->valueResolver() : $field->valueResolver;

        return $valueTransformer->transform($this->data[$name], $arguments);
    }

    private function getValueFromObjectResolver(
        DataField $field,
        ReflectionIntersectionType|ReflectionNamedType|ReflectionUnionType $reflectionType,
        string $name
    ): mixed {
        /** @var TransformerInterface $objectTransformer */
        $objectTransformer = is_string($field->objectTransformer) ? new $field->objectTransformer() : $field->objectTransformer;

        /** @var class-string $objectClass */
        $objectClass = $this->getType($reflectionType);

        return $objectTransformer->transform($objectClass, $this->data[$name]);
    }
}
