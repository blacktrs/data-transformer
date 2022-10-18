<?php

namespace Blacktrs\DataTransformer\Tests\Fake\Item\Transform;

class FakeObjectWithPrivateProperties
{
    private string $name;
    private int $age;

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }
}