<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum IntentEnum: string
{
    case Positive = 'positive';
    case Negative = 'negative';
    case Default = 'default';
}
