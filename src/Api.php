<?php

namespace VioletSun\MAX;

use VioletSun\MAX\Methods\Get;
use VioletSun\MAX\Methods\Message;

class Api
{
    use Get;
    use Message;

    public function __construct(protected Client $client)
    {
    }
}
