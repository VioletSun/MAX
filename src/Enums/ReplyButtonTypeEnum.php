<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum ReplyButtonTypeEnum: string
{
    case Message = 'message';
    case UserGeoLocation = 'user_geo_location';
    case UserContact = 'user_contact';
}
