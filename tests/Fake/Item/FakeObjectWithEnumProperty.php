<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

use Blacktrs\DataTransformer\Tests\Fake\Enum\{FakeColorEnum, FakeSizeEnum};

class FakeObjectWithEnumProperty
{
    public int $id;

    public string $name;

    public FakeColorEnum $color;

    public FakeSizeEnum $size;
}
