<?php

namespace Blacktrs\DataTransformer\Tests\Fake\Item\Transform;

use Blacktrs\DataTransformer\Attribute\Field;

class FakeSimpleObject
{
    public readonly int $id;

    public readonly string $label;

    #[Field(ignoreTransform: true)]
    public readonly string $description;

    public function __construct()
    {
        $this->description = 'My fake description';
    }
}
