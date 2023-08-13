<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Item;

class FakeObjectWithStringableProperty
{
    public int $id;

    public string $label;

    public FakeStringableObject $data;
}
