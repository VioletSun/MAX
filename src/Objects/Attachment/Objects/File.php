<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $filename
 * @property int $size
 */
final class File extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'filename' => $data['filename'] ?? null,
            'size' => $data['size'] ?? null,
        ]);
    }
}
