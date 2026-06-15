<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum MessageLinkTypeEnum: string
{
    case Forward = 'forward';
    case Reply = 'reply';
}
