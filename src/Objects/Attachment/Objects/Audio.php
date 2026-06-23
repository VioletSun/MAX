<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Objects\Attachment\Payloads\AudioPayload;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $transcription
 * @property AudioPayload|null $payload
 */
final class Audio extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'transcription' => $data['transcription'] ?? null,
            'payload' => $data['payload'] ?? null,
        ]);
    }
}
