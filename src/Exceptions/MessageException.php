<?php

namespace VioletSun\MAX\Exceptions;

use Exception;
use VioletSun\MAX\Objects\AbstractObject;

class MessageException extends Exception
{
    public static function required(string $key): self
    {
        return new self("Required parameter '{$key}'");
    }

    public static function uploads(AbstractObject $object): self
    {
        return new self(
            message: "Exception while uploading file: " . $object->toJson()
        );
    }
}
