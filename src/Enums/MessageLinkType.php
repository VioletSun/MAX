<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum MessageLinkType: string
{
    case Forward = 'forward';
    case Reply = 'reply';
}
