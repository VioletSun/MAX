<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $transcription
 */
final class Audio extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'transcription' => $data['transcription'] ?? null,
        ]);
    }
}
