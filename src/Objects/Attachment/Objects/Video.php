<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property int $duration
 */
final class Video extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'duration' => $data['duration'] ?? null,
        ]);
    }
}
