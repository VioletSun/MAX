<?php

declare(strict_types=1);

namespace VioletSun\MAX\Exceptions;

use Exception;
use VioletSun\MAX\Objects\AbstractObject;

class WebhookException extends Exception
{
    public static function required(): self
    {
        return new self("Required max bot api secret");
    }
}
