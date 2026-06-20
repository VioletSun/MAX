<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property int $width
 * @property int $height
 */
final class Sticker extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'width' => $data['width'] ?? null,
            'height' => $data['height'] ?? null,
        ]);
    }
}
