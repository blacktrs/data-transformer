<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Transformer;

use Blacktrs\DataTransformer\Tests\Fake\Item\FakeSimpleObject;
use Blacktrs\DataTransformer\Transformer\CollectionObjectTransformer;
use PHPUnit\Framework\TestCase;

class CollectionObjectTransformerTest extends TestCase
{
    public function testCollectionTransformation(): void
    {
        $transformer = new CollectionObjectTransformer();

        $data = [
            ['id' => 1, 'label' => 'First Label'],
            ['id' => 20000, 'label' => 'Second Label'],
        ];

        $collection = $transformer->transform(FakeSimpleObject::class, $data);

        self::assertContainsOnlyInstancesOf(FakeSimpleObject::class, $collection);
    }
}
