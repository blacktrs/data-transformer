<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\RandomUserApi;

use Blacktrs\DataTransformer\Tests\Fake\RandomUserApi\RandomUser;
use Blacktrs\DataTransformer\Transformer\CollectionTransformer;
use PHPUnit\Framework\TestCase;

use function count;

class RandomUserApiResponseTransformerTest extends TestCase
{
    public function testApiTransformer(): void
    {
        // Mocked response from https://randomuser.me/api/?results=5&nat=us,gb&inc=email,name,location,phone
        $json = file_get_contents(__DIR__.'/_mock/mock.json');
        $users = json_decode($json, true)['results'];

        $transformer = new CollectionTransformer();
        /** @var array<RandomUser> $collection */
        $collection = $transformer->transform(RandomUser::class, $users);

        self::assertCount(count($users), $collection);
        self::assertContainsOnlyInstancesOf(RandomUser::class, $collection);

        foreach ($users as $i => $user) {
            $randomUser = $collection[$i];
            self::assertSame($user['name']['first'], $randomUser->name->firstName);
            self::assertSame($user['name']['last'], $randomUser->name->lastName);
            self::assertSame($user['name']['title'], $randomUser->name->title);
            self::assertSame($user['phone'], $randomUser->phone);
            self::assertSame($user['email'], $randomUser->email);
            self::assertSame($user['location']['city'], $randomUser->location->city);
            self::assertSame($user['location']['state'], $randomUser->location->state);
            self::assertSame($user['location']['country'], $randomUser->location->country);
            self::assertSame($user['location']['postcode'], $randomUser->location->postcode);
            self::assertSame($user['location']['street']['name'], $randomUser->location->street->name);
            self::assertSame($user['location']['street']['number'], $randomUser->location->street->number);
            self::assertSame($user['location']['coordinates']['latitude'], $randomUser->location->coordinates->latitude);
            self::assertSame($user['location']['coordinates']['longitude'], $randomUser->location->coordinates->longitude);
            self::assertSame($user['location']['timezone']['offset'], $randomUser->location->timezone->offset);
            self::assertSame($user['location']['timezone']['description'], $randomUser->location->timezone->description);
        }

    }
}
