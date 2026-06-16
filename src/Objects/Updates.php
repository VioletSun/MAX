<?php

namespace VioletSun\MAX\Objects;

/**
 * @property Update[] $updates
 * @property int $marker
 */
class Updates extends BaseObject
{
    protected static array $schema = [
        'updates[]' => Update::class, // список апдейтов
    ];
}
