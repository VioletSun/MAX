<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Payloads;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $code
 * @property string $url
 */
final class StickerPayload extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'code' => $data['code'] ?? null,
            'url' => $data['url'] ?? null,
        ]);
    }
}
