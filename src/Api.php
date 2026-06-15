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

    public function send(int|string $chat_id, array $data): array
    {
        return $this->client->post("messages", $data, ["chat_id" => $chat_id]);
    }
}
