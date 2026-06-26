<?php

namespace VioletSun\MAX\Objects\Chat;

use Carbon\Carbon;
use VioletSun\MAX\Enums\ChatStatusEnum;
use VioletSun\MAX\Enums\ChatTypeEnum;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property int $chat_id
 * @property ChatTypeEnum $type
 * @property ChatStatusEnum $status
 * @property string $title
 * @property Carbon $last_event_time
 * @property int $participants_count
 * @property bool $is_public
 * @property string $link
 * @property int $messages_count
 */
final class Chat extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'chat_id' => $data['chat_id'] ?? null,
            'type' => !empty($data['type']) ? ChatTypeEnum::tryFrom($data['type']) : null,
            'status' => !empty($data['status']) ? ChatStatusEnum::tryFrom($data['status']) :null,
            'title' => $data['title'] ?? null,
            'last_event_time' => !empty($data['last_event_time']) ? Carbon::createFromTimestampMs($data['last_event_time']) : null,
            'participants_count' => $data['participants_count'] ?? null,
            'is_public' => $data['is_public'] ?? null,
            'link' => $data['link'] ?? null,
            'messages_count' => $data['messages_count'] ?? null,
        ]);
    }
}
