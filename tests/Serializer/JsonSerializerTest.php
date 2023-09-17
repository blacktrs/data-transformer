<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Serializer;

use Blacktrs\DataTransformer\Serializer\Serializer\JsonSerializer;
use Blacktrs\DataTransformer\Tests\Fake\Item\{FakeObjectWithConstructorAndGetters, FakeSimpleObjectWithConstructor};
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    private JsonSerializer $serializer;

    protected function setUp(): void
    {
        $this->serializer = new JsonSerializer();
    }

    public function testJsonSerializer(): void
    {
        $fakeObject = new FakeSimpleObjectWithConstructor(100, 'Some label');
        $result = $this->serializer->serialize($fakeObject);

        self::assertJson($result);
    }

    public function testForcePrivatePropertyJsonSerialize(): void
    {
        $fakeObject = new FakeObjectWithConstructorAndGetters('John Doe', 42);
        $fakeObject->setCity('Lviv');
        $fakeObject->setPostcode(79000);

        $result = $this->serializer->setIncludePrivateProperties(true)->serialize($fakeObject);
        static::assertJson($result);
    }
}
