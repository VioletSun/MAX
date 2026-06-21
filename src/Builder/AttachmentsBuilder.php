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

    public function image(string $token): self
    {
        $this->attachments[] = [
            'type' => 'image',
            'payload' => [
                'token' => $token
            ]
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
