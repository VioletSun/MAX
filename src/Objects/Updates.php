<?php

namespace VioletSun\MAX\Objects;

/**
 * @property Update[] $updates
 * @property int $marker
 * @property ?bool $save_data
 */
class Updates extends BaseObject
{
    protected static array $schema = [
        'updates[]' => Update::class, // список апдейтов
    ];
}
