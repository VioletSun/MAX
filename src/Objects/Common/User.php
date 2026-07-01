<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Common;

use Carbon\Carbon;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property int|null $user_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property bool|null $is_bot
 * @property Carbon|null $last_activity_time
 * @property string|null $avatar_url
 * @property string|null $full_avatar_url
 * @property mixed $username
 * @property string|null $name
 */
final class User extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'user_id' => $data['user_id'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'is_bot' => $data['is_bot'] ?? null,
            'last_activity_time' => !empty($data['last_activity_time']) ? now()->createFromTimestampMs($data['last_activity_time']) : null,
            'avatar_url' => $data['avatar_url'] ?? null,
            'full_avatar_url' => $data['full_avatar_url'] ?? null,
            'username' => $data['username'] ?? null,
            'name' => $data['name'] ?? null,
        ]);
    }
}
