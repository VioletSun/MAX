<?php

declare(strict_types=1);

namespace App\Models\Max;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use VioletSun\MAX\Enums\ChatStatusEnum;
use VioletSun\MAX\Enums\ChatTypeEnum;
use VioletSun\MAX\Traits\ChatSendMessage;

/**
 * @property int $id
 * @property int $chat_id
 * @property ChatTypeEnum $type
 * @property ChatStatusEnum $status
 * @property string|null $title
 * @property string|null $description
 * @property array $icon
 * @property int $participants_count
 * @property boolean $is_public
 * @property int $owner_id
 * @property string $link
 * @property int $messages_count
 * @property Carbon $last_event_time
 * @property Carbon $created_at
 * @property Carbon $updatet_at
 * @property Carbon|null $deleted_at
 */
class MaxChat extends Model
{
    use SoftDeletes, ChatSendMessage;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'chat_id',
        'type',
        'status',
        'title',
        'description',
        'icon',
        'participants_count',
        'is_public',
        'owner_id',
        'link',
        'messages_count',
        'last_event_time',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ChatTypeEnum::class,
            'icon' => 'array',
            'is_public' => 'boolean',
            'last_event_time' => 'datetime'
        ];
    }

    public function maxUsers(): BelongsToMany
    {
        return $this->belongsToMany(MaxUser::class, 'max_chat_users', 'chat_id', 'user_id')->withTimestamps();
    }
}
