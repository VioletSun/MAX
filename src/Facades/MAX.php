<?php

namespace VioletSun\MAX\Facades;

use Illuminate\Support\Facades\Facade;

class MAX extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'max';
    }
}
