<?php

namespace VioletSun\MAX\Facades;

use Illuminate\Support\Facades\Facade;
use VioletSun\MAX\Api;

/**
 * @method static array me()
 * @method static array send(int|string $chat_id, array $data)
 *
 * @see Api
 */
class MAX extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'max.api';
    }
}
