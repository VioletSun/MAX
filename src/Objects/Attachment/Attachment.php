<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Attachment;

use VioletSun\MAX\Enums\AttachmentTypeEnum;
use VioletSun\MAX\Objects\Attachment\Objects\Share;
use VioletSun\MAX\Support\BaseObject;

final class Attachment extends BaseObject
{
    public static function fromArrayData(array $data): BaseObject
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
        return new Attachment($data);
    }

    protected static function makeObject($folder, $className, $data): Attachment|BaseObject|Share
    {
        $class = 'VioletSun\\MAX\\Objects\\Attachment\\' . $folder . '\\' . $className;
        if (class_exists($class) && method_exists($class, 'fromArray')) {
            /** @var class-string<Attachment> $class */
            return $class::fromArray($data);
        }
        return new Attachment($data);
    }
}
