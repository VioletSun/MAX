<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Objects\Attachment\Payloads\SharePayload;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property string|null $title
 * @property string|null $description
 * @property string|null $image_url
 * @property SharePayload|null $payload
 */
final class Share extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'image_url' => $data['image_url'] ?? null,
            'payload' => $data['payload'] ?? null,
        ]);
    }
}
