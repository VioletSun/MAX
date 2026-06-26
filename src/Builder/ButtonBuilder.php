<?php

namespace VioletSun\MAX\Builder;

use VioletSun\MAX\Enums\InlineButtonTypeEnum;

class ButtonBuilder
{
    public function callback(string $text, string $payload): array
    {
        return [
            'type' => InlineButtonTypeEnum::Callback,
            'text' => $text,
            'payload' => $payload
        ];
    }

    public function link(string $text, string $url): array
    {
        return [
            'type' => InlineButtonTypeEnum::Link,
            'text' => $text,
            'url' => $url
        ];
    }

    public function requestGeoLocation(string $text, ?bool $quick = true): array
    {
        return [
            'type' => InlineButtonTypeEnum::RequestGeoLocation,
            'text' => $text,
            'quick' => $quick
        ];
    }

    public function requestContact(string $text): array
    {
        return [
            'type' => InlineButtonTypeEnum::RequestContact,
            'text' => $text
        ];
    }

    public function openApp(string $text, ?string $web_app = null, ?int $contact_id = null, ?string $payload = null): array
    {
        $data = [
            'type' => InlineButtonTypeEnum::OpenApp,
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
            'type' => InlineButtonTypeEnum::Message,
            'text' => $text
        ];
    }

    public function clipboard(string $text, string $payload): array
    {
        return [
            'type' => InlineButtonTypeEnum::Clipboard,
            'text' => $text,
            'payload' => $payload
        ];
    }
}
