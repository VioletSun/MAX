<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment;

use VioletSun\MAX\Enums\AttachmentTypeEnum;
use VioletSun\MAX\Support\BaseObject;

final class Attachment extends BaseObject
{
    public static function fromArray(array $data): static
    {
        $type = isset($data['type']) ? AttachmentTypeEnum::tryFrom($data['type']) : null;
        if (!empty($type)) {
            $data['type'] = $type;
        }

        $payloadRaw = $data['payload'] ?? null;
        if ($type !== null && $payloadRaw !== null) {
            $payload = self::makeObject('Payloads', $type->toCamelCase() . 'Payload', $payloadRaw);
            $data['payload'] = $payload;
        }

        $thumbnailRaw = $data['thumbnail'] ?? null;
        if ($type !== null && $thumbnailRaw !== null) {
            $thumbnail = self::makeObject('Thumbnails', $type->toCamelCase() . 'Thumbnail', $thumbnailRaw);
            $data['thumbnail'] = $thumbnail;
        }

        if ($type !== null) {
            return self::makeObject('Objects', $type->toCamelCase(), $data);
        }
        return new self($data);
    }

    private static function makeObject($folder, $className, $data): Attachment|BaseObject
    {
        $class = 'VioletSun\\MAX\\Objects\\Attachment\\' . $folder . '\\' . $className;
        if (class_exists($class) && method_exists($class, 'fromArray')) {
            /** @var class-string<BaseObject> $class */
            return $class::fromArray($data);
        }
        return new self($data);
    }
}
