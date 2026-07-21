<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Chat;

use Carbon\Carbon;
use VioletSun\MAX\Enums\ChatStatusEnum;
use VioletSun\MAX\Enums\ChatTypeEnum;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property string $url
 * @property string $token
 * @property array $photos
 */
final class ChatIcon extends BaseObject
{
    /**
     * @param array $data
     * <code>
     * $data = [
     *  'url' => '',    // string - Optional. Any external URL of the image you want to attach
     *  'token' => '',  // string - Optional. Existing investment token
     *  'photos' => [], // array  - Optional. Tokens received after uploading images
     * ]
     * </code>
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new self($data);
    }
}
