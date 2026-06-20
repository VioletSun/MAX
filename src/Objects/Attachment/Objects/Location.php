<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Objects;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property float|null $latitude
 * @property float|null $longitude
 */
final class Location extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
        ]);
    }
}
