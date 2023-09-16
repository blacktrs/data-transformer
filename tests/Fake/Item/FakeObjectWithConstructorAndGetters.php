<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

class FakeObjectWithConstructorAndGetters
{
    private string $city;

    private int $postcode;

    public function __construct(
        private string $name,
        private int $age
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostcode(): int
    {
        return $this->postcode;
    }
}
