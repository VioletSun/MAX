<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects;

use Carbon\Carbon;
use VioletSun\MAX\Enums\UpdateTypeEnum;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $url
 * @property Carbon $time
 * @property UpdateTypeEnum[] $update_types
 */
final class Subscription extends BaseObject
{
    public static function fromArray(array $data): static
    {
        $update_types = [];
        foreach ($data['update_types'] ?? [] as $update_type) {
            $update_types[] = UpdateTypeEnum::tryFrom($update_type);
        }
        return new static([
            'url' => $data['url'],
            'time' => self::carbonFromTimestampMs($data['time'] ?? null),
            'update_types' => $update_types,
        ]);
    }
}
