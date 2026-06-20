<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Message;

use VioletSun\MAX\Support\BaseObject;

final class Markup extends BaseObject
{
    public static function fromArray(array $data): static
    {
        return new self([
            'from' => $data['from'] ?? null,
            'length' => $data['length'] ?? null,
            'type' => $data['type'] ?? null,
        ]);
    }
}
