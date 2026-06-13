<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum Intent: string
{
    case Positive = 'positive';
    case Negative = 'negative';
    case Default = 'default';
}
