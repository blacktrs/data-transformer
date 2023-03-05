<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Transformer;

use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObject;
use Blacktrs\DataTransformer\Transformer\GeneratorTransformer;
use PHPUnit\Framework\TestCase;
use Generator;

class GeneratorTransformerTest extends TestCase
{
    public function testTransform(): void
    {
        $data = [
            ['id' => 1, 'label' => 'First Label'],
            ['id' => 20000, 'label' => 'Second Label'],
        ];

        $transformer = new GeneratorTransformer();
        $collection = $transformer->transform(FakeSimpleObject::class, $data);

        self::assertInstanceOf(Generator::class, $collection);
    }
}
