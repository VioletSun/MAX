<?php

declare(strict_types=1);

namespace VioletSun\MAX\Builder;

use VioletSun\MAX\Enums\InlineButtonTypeEnum;

class ButtonBuilder
{
    /**
     * @param string $text
     * @param string $payload
     * @return array
     */
    public function callback(string $text, string $payload): array
    {
        return [
            'type' => InlineButtonTypeEnum::Callback,
            'text' => $text,
            'payload' => $payload
        ];
    }

    /**
     * @param string $text
     * @param string $url
     * @return array
     */
    public function link(string $text, string $url): array
    {
        return [
            'type' => InlineButtonTypeEnum::Link,
            'text' => $text,
            'url' => $url
        ];
    }

    /**
     * @param string $text
     * @param bool|null $quick
     * @return array
     */
    public function requestGeoLocation(string $text, ?bool $quick = true): array
    {
        return [
            'type' => InlineButtonTypeEnum::RequestGeoLocation,
            'text' => $text,
            'quick' => $quick
        ];
    }

    /**
     * @param string $text
     * @return array
     */
    public function requestContact(string $text): array
    {
        return [
            'type' => InlineButtonTypeEnum::RequestContact,
            'text' => $text
        ];
    }

    /**
     * @param string $text
     * @param string|null $web_app
     * @param int|null $contact_id
     * @param string|null $payload
     * @return array
     */
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

    /**
     * @param string $text
     * @return array
     */
    public function message(string $text): array
    {
        return [
            'type' => InlineButtonTypeEnum::Message,
            'text' => $text
        ];
    }

    /**
     * @param string $text
     * @param string $payload
     * @return array
     */
    public function clipboard(string $text, string $payload): array
    {
        return [
            'type' => InlineButtonTypeEnum::Clipboard,
            'text' => $text,
            'payload' => $payload
        ];
    }
}
