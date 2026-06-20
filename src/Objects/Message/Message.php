<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Message;

use VioletSun\MAX\Objects\Common\User;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property Recipient|null $recipient
 * @property int|null $timestamp
 * @property Body|null $body
 * @property User|null $sender
 */
final class Message extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'recipient' => isset($data['recipient']) ? Recipient::fromArray($data['recipient']) : null,
            'timestamp' => $data['timestamp'] ?? null,
            'body' => isset($data['body']) ? Body::fromArray($data['body']) : null,
            'sender' => isset($data['sender']) ? User::fromArray($data['sender']) : null,
        ]);
    }
}
