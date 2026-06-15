<?php

namespace VioletSun\MAX;

class Api
{
    public function __construct(protected Client $client)
    {
    }

    public function me(): array
    {
        return $this->client->get("me");
    }
}
