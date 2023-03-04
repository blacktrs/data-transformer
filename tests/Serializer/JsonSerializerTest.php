<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Serializer;

use Blacktrs\DataTransformer\Serializer\Serializer\JsonSerializer;
use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObjectWithConstructor;
use PHPUnit\Framework\TestCase;

class JsonSerializerTest extends TestCase
{
    public function testJsonSerializer(): void
    {
        $fakeObject = new FakeSimpleObjectWithConstructor(100, 'Some label');
        $serializer = new JsonSerializer();
        $result = $serializer->serialize($fakeObject);

        self::assertJson($result);
    }
}
