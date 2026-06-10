<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum UploadType: string
{
    case Image = 'image';
    case Video = 'video';
    case Audio = 'audio';
    case File = 'file';
}
