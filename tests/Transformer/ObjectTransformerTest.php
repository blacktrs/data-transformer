<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Transformer;

use Blacktrs\DataTransformer\Transformer\{Transformer, TransformerException};
use Blacktrs\DataTransformer\Tests\Fake\Item\{FakeObjectWithConstructorAndGetters,
    FakeObjectWithEnumProperty,
    FakeObjectWithFieldNameDeclaration,
    FakeObjectWithFieldResolver,
    FakeObjectWithOtherItem,
    FakeObjectWithPrivateProperties,
    FakeSimpleObject,
    FakeSimpleObjectWithConstructor
};
use PHPUnit\Framework\TestCase;
use DateTime;

class ObjectTransformerTest extends TestCase
{
    private Transformer $transformer;

    public function setUp(): void
    {
        $this->transformer = new Transformer();
    }

    public function testSimpleTransformation(): void
    {
        $bytes = random_bytes(10);

        $data = ['id' => 2, 'label' => 'Test Label', 'description' => 'some text', 'context' => null, 'unknownType' => $bytes];

        /** @var FakeSimpleObject $fakeObject */
        $fakeObject = $this->transformer->transform(FakeSimpleObject::class, $data);

        self::assertSame($data['id'], $fakeObject->id);
        self::assertSame($data['label'], $fakeObject->label);
        self::assertNotSame($data['description'], $fakeObject->description);
        self::assertNull($fakeObject->context);
        self::assertSame($bytes, $fakeObject->unknownType);
    }

    public function testCustomFieldNameDeclaration(): void
    {
        $data = ['origin_name' => 'camel cased property'];

        /** @var FakeObjectWithFieldNameDeclaration $fakeObject */
        $fakeObject = $this->transformer->transform(FakeObjectWithFieldNameDeclaration::class, $data);

        self::assertSame($data['origin_name'], $fakeObject->customName);
    }

    public function testFieldTransformation(): void
    {
        $data = ['dateTime' => '2022-08-30'];

        /** @var FakeObjectWithFieldResolver $fakeObject */
        $fakeObject = $this->transformer->transform(FakeObjectWithFieldResolver::class, $data);

        $dateTime = new DateTime($data['dateTime']);
        self::assertSame($dateTime->format('Y-m-d'), $fakeObject->dateTime->format('Y-m-d'));
    }

    public function testNestedItemTransformation(): void
    {
        $data = ['objectId' => 'id-123', 'fake_simple_object' => ['id' => 2, 'label' => 'Test Label', 'description' => 'some text']];

        /** @var FakeObjectWithOtherItem $fakeObject */
        $fakeObject = $this->transformer->transform(FakeObjectWithOtherItem::class, $data);

        self::assertSame($data['objectId'], $fakeObject->objectId);
        self::assertSame($data['fake_simple_object']['id'], $fakeObject->simpleObject->id);
    }

    public function testObjectWithPrivateProperties(): void
    {
        $data = ['name' => 'John Doe', 'age' => 42];

        /** @var FakeObjectWithPrivateProperties $fakeObject */
        $fakeObject = $this->transformer->transform(FakeObjectWithPrivateProperties::class, $data);

        self::assertSame($data['name'], $fakeObject->getName());
        self::assertNotSame($data['age'], $fakeObject->getAge());
    }

    public function testCustomPropertyResolver(): void
    {
        $data = ['name' => 'John Doe', 'age' => 42];

        /** @var FakeObjectWithPrivateProperties $fakeObject */
        $fakeObject = $this->transformer->transform(FakeObjectWithPrivateProperties::class, $data);

        self::assertNotSame($fakeObject->getAge(), $data['age']);
    }

    public function testEnumPropertyTransformation(): void
    {
        $data = ['id' => 1, 'name' => 'John Doe', 'color' => 'green', 'size' => 'L'];

        /** @var FakeObjectWithEnumProperty $fakeObject */
        $fakeObject = $this->transformer->transform(FakeObjectWithEnumProperty::class, $data);

        self::assertSame($fakeObject->color->value, $data['color']);
        self::assertSame($fakeObject->size->name, $data['size']);
    }

    public function testUnknownEnumPropertyTransformation(): void
    {
        $data = ['id' => 1, 'name' => 'John Doe', 'color' => 'green', 'size' => 'XXL'];

        $this->expectException(TransformerException::class);
        $this->transformer->transform(FakeObjectWithEnumProperty::class, $data);
    }

    public function testObjectWithPromotedProperties(): void
    {
        $data = ['id' => 1000, 'label' => 'Constructor promotion'];

        /** @var FakeSimpleObjectWithConstructor $fakeObject */
        $fakeObject = $this->transformer->transform(FakeSimpleObjectWithConstructor::class, $data);

        static::assertSame($data['id'], $fakeObject->id);
        static::assertSame($data['label'], $fakeObject->label);
    }

    public function testForcedPrivatePropertiesWrite(): void
    {
        $data = ['name' => 'John Doe', 'age' => 42];

        /** @var FakeObjectWithPrivateProperties $fakeObject */
        $fakeObject = $this->transformer
            ->setIncludePrivateProperties(true)
            ->transform(FakeObjectWithPrivateProperties::class, $data);

        static::assertSame($data['name'], $fakeObject->getName());
        static::assertSame($data['age'], $fakeObject->getAge());
    }

    public function testInstantiatedObjectFill(): void
    {
        $data = ['city' => 'Lviv', 'postcode' => 79000];
        $fakeObject = new FakeObjectWithConstructorAndGetters('John Doe', 42);

        $fakeObjectCopy = $this->transformer->setIncludePrivateProperties(true)->transform($fakeObject, $data);

        static::assertSame($data['city'], $fakeObjectCopy->getCity());
        static::assertSame($data['postcode'], $fakeObjectCopy->getPostcode());
    }
}
