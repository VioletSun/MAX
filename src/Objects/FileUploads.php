<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property string|null $token
 */
final class FileUploads extends BaseObject
{
    public static function fromArray(array $data): static
    {
        if ($token = self::findToken($data)) {
            $data = ['token' => $token];
        }
        return new self($data);
    }


    /**
     * @param array $array
     * @return mixed|null
     */
    private static function findToken(array $array): mixed
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = self::findToken($value);
                if ($result !== null) {
                    return $result;
                }
            }
            if ($key === 'token') {
                return $value;
            }
        }
        return null;
    }
}
