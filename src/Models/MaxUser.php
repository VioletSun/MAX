<?php

namespace VioletSun\MAX\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use VioletSun\MAX\Models\Max\UserWithPhoto;

/**
 * @property int $id
 * @property int $remote_chat_id
 * @property int $remote_user_id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $username
 * @property string|null $description
 * @property string|null $avatar_url
 * @property string|null $full_avatar_url
 * @property bool $private
 * @property Carbon $last_active
 * @property Carbon $created_at
 * @property Carbon $updatet_at
 * @property Carbon|null $seleted_at
 */
class MaxUser extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'remote_chat_id',
        'remote_user_id',
        'first_name',
        'last_name',
        'username',
        'description',
        'avatar_url',
        'full_avatar_url',
        'private',
        'last_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'private' => 'boolean',
            'last_active' => 'datetime'
        ];
    }

    public static function set(?UserWithPhoto $user = null, ?int $remote_chat_id = -1): ?self
    {
        if (is_null($user) || $user->isBot) {
            return null;
        }

        $last_active = Carbon::createFromTimestamp($user->lastActivityTime);

        return self::query()->updateOrCreate(
            [
                'remote_chat_id' => $remote_chat_id,
                'remote_user_id' => $user->userId,
            ],
            [
                'first_name' => $user->firstName,
                'last_name' => $user->lastName,
                'username' => $user->username,
                'description' => $user->description,
                'avatar_url' => $user->avatarUrl,
                'full_avatar_url' => $user->fullAvatarUrl,
                'last_active' => $last_active,
            ]
        );
    }
}
