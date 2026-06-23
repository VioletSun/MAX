<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Objects\Attachment\Payloads\FilePayload;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $filename
 * @property int $size
 * @property FilePayload $payload
 */
final class File extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'filename' => $data['filename'] ?? null,
            'size' => $data['size'] ?? null,
            'payload' => $data['payload'] ?? null,
        ]);
    }
}
