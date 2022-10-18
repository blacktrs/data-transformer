<?php

namespace Blacktrs\DataTransformer\Tests\Transformer;

use Blacktrs\DataTransformer\Tests\Fake\Item\{FakeObjectWithFieldNameDeclaration,
    FakeObjectWithFieldTransformer,
    FakeObjectWithOtherItem,
    FakeObjectWithPrivateProperties,
    FakeSimpleObject};
use Blacktrs\DataTransformer\Transformer\ObjectTransformer;
use PHPUnit\Framework\TestCase;

class ItemTransformerTest extends TestCase
{
    private ObjectTransformer $transformer;

    public function setUp(): void
    {
        $this->transformer = new ObjectTransformer();
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

    public function testCamelCaseTransformation(): void
    {
        $data = ['camel_cased_name' => 'camel cased property'];

        /** @var FakeObjectWithFieldNameDeclaration $fakeObject */
        $fakeObject = $this->transformer->transform(FakeObjectWithFieldNameDeclaration::class, $data);

        self::assertSame($data['camel_cased_name'], $fakeObject->camelCasedName);
    }

    public function testFieldTransformation(): void
    {
        $data = ['dateTime' => '2022-08-30'];

        /** @var FakeObjectWithFieldTransformer $fakeObject */
        $fakeObject = $this->transformer->transform(FakeObjectWithFieldTransformer::class, $data);

        $dateTime = new \DateTime($data['dateTime']);
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
        self::assertSame($data['age'], $fakeObject->getAge());
    }
}
