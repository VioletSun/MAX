<?php

namespace VioletSun\MAX\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $chat_id
 * @property int $user_id
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
 * @property Carbon|null $deleted_at
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
        'chat_id',
        'user_id',
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

    public function maxChats(): BelongsToMany
    {
        return $this->belongsToMany(MaxChat::class, 'max_chat_users', 'user_id', 'chat_id')->withTimestamps();
    }
}
