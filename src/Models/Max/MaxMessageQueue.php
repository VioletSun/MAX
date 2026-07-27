<?php

declare(strict_types=1);

namespace VioletSun\MAX\Models\Max;

use Illuminate\Database\Eloquent\Model;
use VioletSun\MAX\Traits\ChatSendMessage;

/**
 * @property int $chat_id
 * @property array $data
 */
class MaxMessageQueue extends Model
{
    use ChatSendMessage;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'chat_id',
        'data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'data' => 'array',
        ];
    }
}
