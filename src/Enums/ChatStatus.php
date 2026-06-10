<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum ChatStatus: string
{
    case Active = 'active';
    case Removed = 'removed';
    case Left = 'left';
    case Closed = 'closed';
    case Suspended = 'suspended';
}
