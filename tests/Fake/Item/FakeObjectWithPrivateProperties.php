<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Attribute\TransformerField;

class FakeObjectWithPrivateProperties
{
    #[TransformerField]
    private string $name;

    private int $age = 0;

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}
