<?php

declare(strict_types=1);

namespace Blacktrs\DataTransformer\Tests\Fake\Enum;

enum FakeColorEnum: string
{
    case RED = 'red';
    case BLUE = 'blue';
    case GREEN = 'green';
}
