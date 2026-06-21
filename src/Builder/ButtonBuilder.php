<?php

namespace VioletSun\MAX\Builder;

class ButtonBuilder
{
    public function callback(string $text, string $payload): array
    {
        return [
            'type' => 'callback',
            'text' => $text,
            'payload' => $payload
        ];
    }

    public function link(string $text, string $url): array
    {
        return [
            'type' => 'link',
            'text' => $text,
            'url' => $url
        ];
    }

    public function requestGeoLocation(string $text, ?bool $quick = true): array
    {
        return [
            'type' => 'request_geo_location',
            'text' => $text,
            'quick' => $quick
        ];
    }

    public function requestContact(string $text): array
    {
        return [
            'type' => 'request_contact',
            'text' => $text
        ];
    }

    public function openApp(string $text, ?string $web_app = null, ?int $contact_id = null, ?string $payload = null): array
    {
        $data = [
            'type' => 'open_app',
            'text' => $text
        ];
        foreach (compact('web_app', 'contact_id', 'payload') as $key => $value) {
            if (!is_null($value)) {
                $data[$key] = $value;
            }
        }
        return $data;
    }

    public function message(string $text): array
    {
        return [
            'type' => 'message',
            'text' => $text
        ];
    }

    public function clipboard(string $text, string $payload): array
    {
        return [
            'type' => 'clipboard',
            'text' => $text,
            'payload' => $payload
        ];
    }
}
