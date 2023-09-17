<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\RandomUserApi;

readonly class Location
{
    public Street $street;

    public string $city;

    public string $state;

    public string $country;

    public int|string $postcode;

    public Coordinates $coordinates;

    public Timezone $timezone;
}
