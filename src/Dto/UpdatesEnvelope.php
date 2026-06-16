<?php

namespace VioletSun\MAX\Dto;

class UpdatesEnvelope extends BaseObject
{
    protected static array $schema = [
        'updates[]' => UpdateItem::class, // список апдейтов
    ];

    /**
     * @return UpdateItem[]
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
