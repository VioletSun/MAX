<?php

namespace VioletSun\MAX\Objects\Chat;

use Carbon\Carbon;
use VioletSun\MAX\Enums\ChatAdminPermissionEnum;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property Carbon|null $last_access_time- @deprecated
 * @property bool $is_owner
 * @property bool $is_admin
 * @property mixed $join_time
 * @property ChatAdminPermissionEnum[] $permissions
 * @property int $user_id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $username
 * @property bool $is_bot
 * @property Carbon|null $last_activity_time
 * @property string|null $description
 * @property string|null $avatar_url
 * @property string|null $full_avatar_url
 * @property string|null $name - @deprecated
 */
final class Member extends BaseObject
{
    public static function fromArray(array $data): static
    {
        $permissions = [];
        foreach ($data['permissions'] ?? [] as $permission) {
            $replace = match ($permission) {
                'edit_message' => 'edit',
                'delete_message' => 'delete',
                'post_edit_delete_message' => 'write',
                default => $permission
            };
            $permissions[] = ChatAdminPermissionEnum::tryFrom($replace);
        }
        return new self([
            'last_access_time' => !empty($data['last_access_time']) ? Carbon::createFromTimestampMs($data['last_access_time']) : null,
            'is_owner' => $data['is_owner'] ?? false,
            'is_admin' => $data['is_admin'] ?? false,
            'join_time' => !empty($data['join_time']) ? Carbon::createFromTimestampMs($data['join_time']) : null,
            'permissions' => $permissions,
            'user_id' => $data['user_id'] ?? null,
            'first_name' => $data['first_name'] ?? null,
            'last_name' => $data['last_name'] ?? null,
            'username' => $data['username'] ?? null,
            'is_bot' => $data['is_bot'] ?? false,
            'last_activity_time' => !empty($data['last_activity_time']) ? Carbon::createFromTimestampMs($data['last_activity_time']) : null,
            'description' => $data['description'] ?? null,
            'avatar_url' => $data['avatar_url'] ?? null,
            'full_avatar_url' => $data['full_avatar_url'] ?? null,
            'name' => $data['name'] ?? null,
        ]);
    }
}
