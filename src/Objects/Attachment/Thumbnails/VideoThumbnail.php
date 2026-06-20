<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Thumbnails;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $url
 */
final class VideoThumbnail extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'url' => $data['url'] ?? null,
        ]);
    }
}
