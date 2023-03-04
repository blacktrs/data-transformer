<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Serializer;

use Blacktrs\DataTransformer\Serializer\CollectionSerializer;
use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObjectWithConstructor;
use PHPUnit\Framework\TestCase;

use function count;

class CollectionSerializerTest extends TestCase
{
    public function testArrayCollectionSerialize(): void
    {
        $serializer = new CollectionSerializer();
        $data = [
            new FakeSimpleObjectWithConstructor(123, 'First label'),
            new FakeSimpleObjectWithConstructor(1000, 'Second label')
        ];

        $result = $serializer->serialize($data);

        self::assertCount(count($data), $result);
        self::assertIsArray($result[0]);
        self::assertIsArray($result[1]);
    }
}
