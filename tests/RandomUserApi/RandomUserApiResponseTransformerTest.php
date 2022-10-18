<?php

namespace Blacktrs\DataTransformer\Tests\Transformer;

use Blacktrs\DataTransformer\Tests\Fake\RandomUserApi\RandomUser;
use Blacktrs\DataTransformer\Transformer\CollectionObjectTransformer;
use PHPUnit\Framework\TestCase;

class RandomUserApiTest extends TestCase
{
    public function testApiTransformer(): void
    {
        $url = 'https://randomuser.me/api/?results=5&nat=us,gb&inc=email,name';
        $json = file_get_contents($url);
        $users = json_decode($json, true)['results'];

        $transformer = new CollectionObjectTransformer();
        $collection = $transformer->transform(RandomUser::class, $users);

        self::assertCount(\count($users), $collection);
        self::assertContainsOnlyInstancesOf(RandomUser::class, $collection);
    }
}