<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Serializer;

use Blacktrs\DataTransformer\Serializer\Serializer\{CollectionSerializer, GeneratorSerializer};
use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObjectWithConstructor;
use PHPUnit\Framework\TestCase;
use Generator;

class GeneratorSerializerTest extends TestCase
{
    public function testGeneratorSerialize(): void
    {
        $serializer = new GeneratorSerializer();

        $result = $serializer->serialize(new FakeSimpleObjectWithConstructor(123, 'First label'));

        self::assertInstanceOf(Generator::class, $result);

        foreach ($result as $key => $value) {
            self::assertContains($key, ['id', 'label']);
            self::assertContains($value, [123, 'First label']);
        }
    }
}
