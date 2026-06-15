<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum ChatTypeEnum: string
{
    case Dialog = 'dialog';
    case Chat = 'chat';
    case Channel = 'channel';
}
