<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;

class FakeSimpleObject
{
    public int $id;
    public string $label;

    #[TransformerField(ignoreTransform: true)]
    public string $description;

    public function __construct()
    {
        $this->description = 'My fake description';
    }
}
