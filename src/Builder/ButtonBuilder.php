<?php

namespace VioletSun\MAX\Builder;

class ButtonBuilder
{
    public function link(string $text, string $url): array
    {
        return [
            'type' => 'link',
            'text' => $text,
            'url' => $url
        ];
    }

    public function callback(string $text, string $payload): array
    {
        return [
            'type' => 'callback',
            'text' => $text,
            'payload' => $payload
        ];
    }
}
