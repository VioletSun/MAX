<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Callback;

use VioletSun\MAX\Objects\Common\User;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property int|null $timestamp
 * @property string|null $callback_id
 * @property string|null $payload
 * @property User|null $user
 */
final class Callback extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'timestamp' => $data['timestamp'] ?? null,
            'callback_id' => $data['callback_id'] ?? null,
            'payload' => $data['payload'] ?? null,
            'user' => isset($data['user']) ? User::fromArray($data['user']) : null,
        ]);
    }

    /**
     * @param int|null $key
     * @param mixed|null $default
     * @param string $separator
     * @return mixed|string|array|null
     */
    public function payload(?int $key = null, mixed $default = null, string $separator = ':'): mixed
    {
        $array = explode($separator, $this->payload);
        if ($key === null) {
            return $array;
        }
        return $array[$key] ?? $default;
    }
}
