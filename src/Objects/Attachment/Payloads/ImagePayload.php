<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Payloads;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property int $photo_id
 * @property string $token
 * @property string $url
 */
final class ImagePayload extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'photo_id' => $data['photo_id'] ?? null,
            'token' => $data['token'] ?? null,
            'url' => $data['url'] ?? null,
        ]);
    }
}
