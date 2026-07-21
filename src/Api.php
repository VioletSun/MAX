<?php

declare(strict_types=1);

namespace VioletSun\MAX;

use VioletSun\MAX\Methods\Chat;
use VioletSun\MAX\Methods\Get;
use VioletSun\MAX\Methods\Message;
use VioletSun\MAX\Methods\Uploads;
use VioletSun\MAX\Methods\Webhook;

class Api
{
    use Get;
    use Message;
    use Chat;
    use Webhook;
    use Uploads;

    public function __construct(protected Client $client)
    {
    }
}
