<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Transformer;

use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObject;
use Blacktrs\DataTransformer\Transformer\CollectionTransformer;
use PHPUnit\Framework\TestCase;

class CollectionTransformerTest extends TestCase
{
    public function testCollectionTransformation(): void
    {
        $transformer = new CollectionTransformer();

        $data = [
            ['id' => 1, 'label' => 'First Label'],
            ['id' => 20000, 'label' => 'Second Label'],
        ];

        $collection = $transformer->transform(FakeSimpleObject::class, $data);

        self::assertContainsOnlyInstancesOf(FakeSimpleObject::class, $collection);
    }
}
