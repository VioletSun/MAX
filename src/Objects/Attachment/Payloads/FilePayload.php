<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Payloads;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $url
 * @property string $token
 * @property int $fileId
 */
final class FilePayload extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'url' => $data['url'] ?? null,
            'token' => $data['token'] ?? null,
            'fileId' => $data['fileId'] ?? null,
        ]);
    }
}
