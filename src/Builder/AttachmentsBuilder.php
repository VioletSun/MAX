<?php

namespace VioletSun\MAX\Builder;

class AttachmentsBuilder
{
    private array $attachments = [];
    public ButtonBuilder $button;

    public function __construct()
    {
        $this->button = new ButtonBuilder();
    }

    public function image(?string $token = null, ?string $url = null): self
    {
        $payload = $token ?? $url ?? null;
        if (!is_null($payload)) {
            $this->attachments[] = [
                'type' => 'image',
                'payload' => [
                    'token' => $token
                ]
            ];
        }
        return $this;
    }

    public function video(string $token): self
    {
        $this->attachments[] = [
            'type' => 'video',
            'payload' => [
                'token' => $token
            ]
        ];
        return $this;
    }

    public function audio(string $token): self
    {
        $this->attachments[] = [
            'type' => 'audio',
            'payload' => [
                'token' => $token
            ]
        ];
        return $this;
    }

    public function file(string $token): self
    {
        $this->attachments[] = [
            'type' => 'file',
            'payload' => [
                'token' => $token
            ]
        ];
        return $this;
    }

    public function sticker(string $code): self
    {
        $this->attachments[] = [
            'type' => 'sticker',
            'payload' => [
                'code' => $code
            ]
        ];
        return $this;
    }

    public function contact(string $name, ?int $contact_id = null, ?string $vcf_info = null, ?string $vcf_phone = null): self
    {
        $payload['name'] = $name;
        foreach (compact('contact_id', 'vcf_info', 'vcf_phone') as $key => $value) {
            if (!is_null($value)) {
                $payload[$key] = $value;
                break;
            }
        }
        $this->attachments[] = [
            'type' => 'contact',
            'payload' => $payload
        ];
        return $this;
    }

    public function location(float $latitude, float $longitude): self
    {
        $this->attachments[] = [
            'type' => 'location',
            'payload' => [
                'latitude' => $latitude,
                'longitude' => $longitude
            ]
        ];
        return $this;
    }

    public function share(?string $url = null, ?string $token = null): self
    {
        $payload = [];
        foreach (compact('url', 'token') as $key => $value) {
            if (!is_null($value)) {
                $payload[$key] = $value;
                break;
            }
        }
        $this->attachments[] = [
            'type' => 'share',
            'payload' => $payload
        ];
        return $this;
    }

    public function inlineKeyboard(...$buttons): self
    {
        $processedButtons = [];

        foreach ($buttons as $button) {
            if (is_array($button) && isset($button['__row'])) {
                // Это ряд кнопок
                $processedButtons[] = $button['buttons'];
            } else {
                // Это одиночная кнопка - помещаем в отдельный ряд
                $processedButtons[] = [$button];
            }
        }

        $this->attachments[] = [
            'type' => 'inline_keyboard',
            'payload' => [
                'buttons' => $processedButtons
            ]
        ];

        return $this;
    }

    public function row(...$buttons): array
    {
        return [
            '__row' => true,
            'buttons' => $buttons
        ];
    }

    public function getAttachments(): array
    {
        return $this->attachments;
    }
}
