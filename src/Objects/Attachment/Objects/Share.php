<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $title
 * @property string $description
 * @property string $image_url
 */
final class Share extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'image_url' => $data['image_url'] ?? null,
        ]);
    }
}
