<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Serializer;

use Blacktrs\DataTransformer\Serializer\ObjectSerializer;
use Blacktrs\DataTransformer\Tests\Fake\Item\{FakeObjectWithFieldResolver,
    FakeObjectWithFieldResolverAndArguments,
    FakeObjectWithGetters,
    FakeObjectWithOtherItem,
    FakeSimpleObject,
    FakeSimpleObjectWithConstructor};
use DateTime;
use PHPUnit\Framework\TestCase;

class ObjectSerializerTest extends TestCase
{
    private ObjectSerializer $serializer;

    public function setUp(): void
    {
        $this->serializer = new ObjectSerializer();
    }

    public function testDefaultObjectSerialize(): void
    {
        $fakeObject = new FakeSimpleObjectWithConstructor(100, 'Some label');

        $result = $this->serializer->serialize($fakeObject);

        self::assertIsArray($result);
        self::assertArrayHasKey('id', $result);
        self::assertIsInt($result['id']);
        self::assertArrayHasKey('label', $result);
        self::assertIsString($result['label']);
    }

    public function testNestedObjectSerialize(): void
    {
        $fakeObject = new FakeObjectWithOtherItem();
        $fakeObject->objectId = '123-test';
        $fakeObject->simpleObject = new FakeSimpleObject();
        $fakeObject->simpleObject->id = 123;
        $fakeObject->simpleObject->label = 'my label';

        $result = $this->serializer->serialize($fakeObject);

        self::assertIsArray($result);
        self::assertArrayHasKey('simpleObject', $result);
        self::assertArrayHasKey('id', $result['simpleObject']);
        self::assertArrayHasKey('label', $result['simpleObject']);
    }

    public function testValueResolverSerialize(): void
    {
        $fakeObject = new FakeObjectWithFieldResolver();
        $fakeObject->dateTime = new DateTime('now');

        $result = $this->serializer->serialize($fakeObject);

        self::assertArrayHasKey('dateTime', $result);
        self::assertSame($result['dateTime'], $fakeObject->dateTime->format(DATE_ATOM));
    }
    public function testValueResolverWithArgumentsSerialize(): void
    {
        $fakeObject = new FakeObjectWithFieldResolverAndArguments();
        $fakeObject->dateTime = new DateTime('now');

        $result = $this->serializer->serialize($fakeObject);

        self::assertArrayHasKey('dateTime', $result);
        self::assertSame($result['dateTime'], $fakeObject->dateTime->format(DATE_RFC7231));
    }

    public function testGetterDataSerialize(): void
    {
        $fakeObject = new FakeObjectWithGetters(name: 'John Doe', age: 42, isHuman: false);
        $result = $this->serializer->serialize($fakeObject);

        self::assertSame('John Doe1', $result['name']);
        self::assertSame(42, $result['age']);
        self::assertTrue($result['isHuman']);
    }
}
