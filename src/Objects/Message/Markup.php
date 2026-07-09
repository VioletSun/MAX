<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Message;

use VioletSun\MAX\Enums\MarkupTypeEnum;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property int $from
 * @property int $length
 * @property string $type
 * @property string|null $url
 * @property string|null $user_link
 * @property int|null $user_id
 */
final class Markup extends BaseObject
{
    public static function fromArray(array $data): static
    {
        $datum = [];
        foreach ($data as $key => $value) {
            if ($key === 'type') {
                $datum[$key] = MarkupTypeEnum::tryFrom($value);
            } else {
                $datum[$key] = $value;
            }
        }
        return new self($datum);
    }
}
