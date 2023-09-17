<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Serializer;

use Blacktrs\DataTransformer\Serializer\GeneratorSerializer;
use Blacktrs\DataTransformer\Serializer\Serializer\ArraySerializer;
use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObjectWithConstructor;
use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class GeneratorSerializerTest extends TestCase
{
    private GeneratorSerializer $generatorSerializer;

    protected function setUp(): void
    {
        $this->generatorSerializer = new GeneratorSerializer();
    }

    #[DataProvider('collectionDataProvider')]
    public function testGeneratorSerialize(array $collection): void
    {

        $result = $this->generatorSerializer->serialize($collection);

        self::assertInstanceOf(Generator::class, $result);

        foreach ($result as $item) {
            self::assertArrayHasKey('id', $item);
            self::assertArrayHasKey('label', $item);
        }
    }

    #[DataProvider('collectionDataProvider')]
    public function testGeneratorSerializeWithSerializerClassName(array $collection): void
    {

        $result = $this->generatorSerializer->serialize($collection, serializer: ArraySerializer::class);

        self::assertInstanceOf(Generator::class, $result);

        foreach ($result as $item) {
            self::assertArrayHasKey('id', $item);
            self::assertArrayHasKey('label', $item);
        }
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
