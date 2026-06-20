<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Message;

use VioletSun\MAX\Enums\ChatTypeEnum;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property int|null $chat_id
 * @property ChatTypeEnum|null $chat_type
 * @property int|null $user_id
 */
final class Recipient extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'chat_id' => $data['chat_id'] ?? null,
            'chat_type' => isset($data['chat_type']) ? ChatTypeEnum::tryFrom($data['chat_type']) : null,
            'user_id' => $data['user_id'] ?? null,
        ]);
    }
}
