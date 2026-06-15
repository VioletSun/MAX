<?php

namespace VioletSun\MAX\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array me()
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
