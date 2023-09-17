<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\DataField;

class FakeSimpleObject
{
    public int $id;

    public string $label;

    public ?string $context;

    #[DataField(ignoreTransform: true)]
    public string $description;

    public $unknownType = null;

    public function __construct()
    {
        $this->description = 'My fake description';
    }
}
