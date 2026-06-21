<?php

namespace VioletSun\MAX\Builder;

use VioletSun\MAX\Enums\MessageFormatEnum;

class MessageBuilder
{
    protected int $chat_id;
    protected bool $disable_link_preview = false;
    protected string $text;
    protected array $attachments;
    protected mixed $link = null;
    protected bool $notify = true;
    protected MessageFormatEnum $format;

    public static function init(): MessageBuilder
    {
        return new self();
    }

    public function text(string $text): MessageBuilder
    {
        $this->text = $text;
        return $this;
    }

    public function disableLinkPreview(): MessageBuilder
    {
        $this->disable_link_preview = true;
        return $this;
    }
}
