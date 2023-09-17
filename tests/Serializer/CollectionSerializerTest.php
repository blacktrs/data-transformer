<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Serializer;

use Blacktrs\DataTransformer\Serializer\CollectionSerializer;
use Blacktrs\DataTransformer\Serializer\Serializer\{ArraySerializer, JsonSerializer};
use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObjectWithConstructor;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use Generator;

use function count;

class CollectionSerializerTest extends TestCase
{
    private CollectionSerializer $serializer;

    protected function setUp(): void
    {
        $this->serializer = new CollectionSerializer();
    }

    #[DataProvider('collectionDataProvider')]
    public function testArrayCollectionSerialize(array $collection): void
    {
        $result = $this->serializer->serialize($collection);

        self::assertCount(count($collection), $result);
        self::assertIsArray($result[0]);
        self::assertIsArray($result[1]);
    }

    public function testArrayEmptyCollection(): void
    {
        $result = $this->serializer->serialize([]);

        static::assertIsArray($result);
        static::assertEmpty($result);
    }

    #[DataProvider('collectionDataProvider')]
    public function testArrayCollectionWithSerializerClassName(array $collection): void
    {
        $result = $this->serializer->serialize($collection, serializer: ArraySerializer::class);

        static::assertIsArray($result);
    }

    public static function collectionDataProvider(): Generator
    {
        yield [
            [
                new FakeSimpleObjectWithConstructor(123, 'First label'),
                new FakeSimpleObjectWithConstructor(1000, 'Second label')
            ]
        ];
    }
}
