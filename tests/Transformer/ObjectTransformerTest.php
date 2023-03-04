<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Transformer;

use Blacktrs\DataTransformer\Tests\Fake\Item\{FakeObjectWithFieldNameDeclaration,
    FakeObjectWithFieldResolver,
    FakeObjectWithOtherItem,
    FakeObjectWithPrivateProperties,
    FakeSimpleObject};
use Blacktrs\DataTransformer\Transformer\Transformer;
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
        $data = ['id' => 2, 'label' => 'Test Label', 'description' => 'some text'];

        /** @var FakeSimpleObject $fakeObject */
        $fakeObject = $this->transformer->transform(FakeSimpleObject::class, $data);

        self::assertSame($data['id'], $fakeObject->id);
        self::assertSame($data['label'], $fakeObject->label);
        self::assertNotSame($data['description'], $fakeObject->description);
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
}
