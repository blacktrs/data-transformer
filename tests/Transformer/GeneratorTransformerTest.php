<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Transformer;

use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObject;
use Blacktrs\DataTransformer\Transformer\GeneratorTransformer;
use PHPUnit\Framework\TestCase;

class GeneratorTransformerTest extends TestCase
{
    private GeneratorTransformer $transformer;

    protected function setUp(): void
    {
        $this->transformer = new GeneratorTransformer();
    }

    public function testTransform(): void
    {
        $data = [
            ['id' => 1, 'label' => 'First Label'],
            ['id' => 20000, 'label' => 'Second Label'],
        ];

        $collection = $this->transformer->transform(FakeSimpleObject::class, $data);

        static::assertContainsOnlyInstancesOf(FakeSimpleObject::class, $collection);
    }
}
