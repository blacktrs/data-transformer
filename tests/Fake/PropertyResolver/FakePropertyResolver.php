<?php

namespace Blacktrs\DataTransformer\Tests\Fake\PropertyResolver;

use Blacktrs\DataTransformer\Attribute\TransformerField;
use Blacktrs\DataTransformer\PropertyResolverInterface;

class FakePropertyResolver implements PropertyResolverInterface
{
    public function resolve(TransformerField $field, \ReflectionProperty $property): void
    {
        // TODO: Implement resolve() method.
    }
}