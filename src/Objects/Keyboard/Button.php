<?php
declare(strict_types=1);

namespace VioletSun\MAX\Objects\Keyboard;

use VioletSun\MAX\Support\BaseObject;

final class Button extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'type' => $data['type'] ?? null, // напр., 'callback'
            'text' => $data['text'] ?? null,
            'payload' => $data['payload'] ?? null,
        ]);
    }
}
