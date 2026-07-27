<?php

declare(strict_types=1);

namespace VioletSun\MAX\Models\Max;

use Illuminate\Database\Eloquent\Model;
use VioletSun\MAX\Builder\MessageBuilder;
use VioletSun\MAX\Exceptions\MessageException;
use VioletSun\MAX\Objects\Message\Message;

/**
 * @property int $chat_id
 * @property array $data
 */
class MaxMessageQueue extends Model
{
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

    public function buildMessage(bool $setChatId = true): MessageBuilder
    {
        $data = $this->data ?? [];

        if ($setChatId) {
            $data['chat_id'] = $this->chat_id;
        }

        return new MessageBuilder($data);
    }

    /**
     * @throws MessageException
     */
    public function sendQueuedMessage(): Message
    {
        return $this->buildMessage()->send();
    }
}
