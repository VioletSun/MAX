<?php

namespace VioletSun\MAX\Builder;

use VioletSun\MAX\Enums\AttachmentTypeEnum;
use VioletSun\MAX\Enums\UploadTypeEnum;
use VioletSun\MAX\Exceptions\MessageException;
use VioletSun\MAX\Facades\MAX;

class AttachmentsBuilder
{
    private array $attachments = [];
    public ButtonBuilder $button;

    public function __construct()
    {
        $this->button = new ButtonBuilder();
    }

    /**
     * @param string|null $token
     * @param array|null $photos
     * @param string|null $url
     * @param string|null $store - in development
     * @return $this
     * @throws MessageException
     */
    public function image(?string $token = null, ?array $photos = [], ?string $url = null, ?string $store = null): self
    {
        if (!empty($store)) {
            $response = MAX::uploads(UploadTypeEnum::Image, $store);
            $token = $response->token;
        }
        $payload = null;
        if (!empty($token)) {
            $payload['token'] = $token;
        } elseif (!empty($photos)) {
            $payload['photos'] = $photos;
        } elseif (!empty($url)) {
            $payload['url'] = $url;
        }
        if (!is_null($payload)) {
            $this->attachments[] = [
                'type' => AttachmentTypeEnum::Image,
                'payload' => $payload
            ];
        }
        return $this;
    }

    /**
     * @param string $token
     * @param string|null $store
     * @return $this
     * @throws MessageException
     */
    public function video(string $token, ?string $store = null): self
    {
        if (!empty($store)) {
            $response = MAX::uploads(UploadTypeEnum::Video, $store);
            $token = $response->token;
        }
        $this->attachments[] = [
            'type' => 'video',
            'payload' => [
                'token' => $token
            ]
        ];
        return $this;
    }

    /**
     * @param string $token
     * @param string|null $store
     * @return $this
     * @throws MessageException
     */
    public function audio(string $token, ?string $store = null): self
    {
        if (!empty($store)) {
            $response = MAX::uploads(UploadTypeEnum::Audio, $store);
            $token = $response->token;
        }
        $this->attachments[] = [
            'type' => 'audio',
            'payload' => [
                'token' => $token
            ]
        ];
        return $this;
    }

    /**
     * @param string $token
     * @param string|null $store
     * @return $this
     * @throws MessageException
     */
    public function file(string $token, ?string $store = null): self
    {
        if (!empty($store)) {
            $response = MAX::uploads(UploadTypeEnum::Image, $store);
            $token = $response->token;
        }
        $this->attachments[] = [
            'type' => 'file',
            'payload' => [
                'token' => $token
            ]
        ];
        return $this;
    }

    /**
     * @param string $code
     * @return $this
     */
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

    /**
     * @param string $name
     * @param int|null $contact_id
     * @param string|null $vcf_info
     * @param string|null $vcf_phone
     * @return $this
     */
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

    /**
     * @param float $latitude
     * @param float $longitude
     * @return $this
     */
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

    /**
     * @param string|null $url
     * @param string|null $token
     * @return $this
     */
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

    /**
     * @param ...$buttons
     * @return $this
     */
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

    /**
     * @param ...$buttons
     * @return array
     */
    public function row(...$buttons): array
    {
        return [
            '__row' => true,
            'buttons' => $buttons
        ];
    }

    /**
     * @return array
     */
    public function getAttachments(): array
    {
        return $this->attachments;
    }
}
