<?php

namespace VioletSun\MAX\Objects;

class Updates extends BaseObject
{
    protected static array $schema = [
        'updates[]' => Update::class, // список апдейтов
    ];

    /**
     * @return Update[]
     */
    public function updates(): array
    {
        return $this->get('updates') ?? [];
    }

    public function marker(): ?int
    {
        return $this->getInt('marker');
    }
}
