<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Chat;

use Carbon\Carbon;
use VioletSun\MAX\Enums\ChatStatusEnum;
use VioletSun\MAX\Enums\ChatTypeEnum;
use VioletSun\MAX\Objects\Common\User;
use VioletSun\MAX\Objects\Update;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property int $chat_id
 * @property ChatTypeEnum $type
 * @property ChatStatusEnum $status
 * @property string $title
 * @property string $icon
 * @property Carbon $last_event_time
 * @property int $participants_count
 * @property int|null $owner_id
 * @property array|null $participants
 * @property bool $is_public
 * @property string|null $link
 * @property string $description
 * @property User|null $dialog_with_user
 * @property int|null $messages_count
 * @property Update|null $pinned_message
 */
final class Chat extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'chat_id' => $data['chat_id'] ?? null,
            'type' => !empty($data['type']) ? ChatTypeEnum::tryFrom($data['type']) : null,
            'status' => !empty($data['status']) ? ChatStatusEnum::tryFrom($data['status']) : null,
            'title' => $data['title'] ?? null,
            'icon' => $data['icon']['url'] ?? null,
            'last_event_time' => self::carbonFromTimestampMs($data['last_event_time'] ?? null),
            'participants_count' => $data['participants_count'] ?? null,
            'owner_id' => $data['owner_id'] ?? null,
            'participants' => $data['participants'] ?? null,
            'is_public' => $data['is_public'] ?? null,
            'link' => $data['link'] ?? null,
            'description' => $data['description'] ?? null,
            'dialog_with_user' => !empty($data['dialog_with_user']) ? User::fromArray($data['dialog_with_user']) : null,
            'messages_count' => $data['messages_count'] ?? null,
            'pinned_message' => !empty($data['pinned_message']) ? Update::fromArray($data['pinned_message']) : null,
        ]);
    }
}
