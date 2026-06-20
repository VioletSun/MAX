<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment\Payloads;

use VioletSun\MAX\Objects\Keyboard\Button;
use VioletSun\MAX\Support\BaseObject;

final class InlineKeyboardPayload extends BaseObject
{
    public static function fromArray(array $data): static
    {
        $rows = [];
        foreach ($data['buttons'] ?? [] as $row) {
            $rows[] = array_map(static fn(array $button) => Button::fromArray($button), $row);
        }
        return new self([
            'buttons' => $rows,
        ]);
    }
}
