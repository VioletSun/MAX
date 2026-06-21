<?php

namespace VioletSun\MAX\Exceptions;

use Exception;

class MessageException extends Exception
{
    public static function required(string $key): self
    {
        return new self("Required parameter '{$key}'");
    }
}
