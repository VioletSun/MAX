<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum Method: string
{
    case GET = 'GET';
    case POST = 'POST';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';
    case PUT = 'PUT';
}
