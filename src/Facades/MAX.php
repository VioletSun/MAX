<?php

declare(strict_types=1);

namespace VioletSun\MAX\Facades;

use Illuminate\Support\Facades\Facade;
use VioletSun\MAX\Api;

/**
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
