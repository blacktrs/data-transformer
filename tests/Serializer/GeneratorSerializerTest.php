<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Serializer;

use Blacktrs\DataTransformer\Serializer\GeneratorSerializer;
use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObjectWithConstructor;
use Generator;
use PHPUnit\Framework\TestCase;

class GeneratorSerializerTest extends TestCase
{
    public function testGeneratorSerialize(): void
    {
        $generatorSerializer= new GeneratorSerializer();
        $data = [
            new FakeSimpleObjectWithConstructor(123, 'First label'),
            new FakeSimpleObjectWithConstructor(1000, 'Second label')
        ];

        $result = $generatorSerializer->serialize($data);

        self::assertInstanceOf(Generator::class, $result);

        foreach ($result as $item) {
            self::assertArrayHasKey('id', $item);
            self::assertArrayHasKey('label', $item);
        }
    }
}
