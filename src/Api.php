<?php

namespace VioletSun\MAX;

use VioletSun\MAX\Methods\Chat;
use VioletSun\MAX\Methods\Get;
use VioletSun\MAX\Methods\Message;

class Api
{
    use Get;
    use Message;
    use Chat;

    public function __construct(protected Client $client)
    {
    }
}
