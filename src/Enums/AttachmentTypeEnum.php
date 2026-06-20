<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum AttachmentTypeEnum: string
{
    case Image = 'image';
    case Video = 'video';
    case Audio = 'audio';
    case File = 'file';
    case Sticker = 'sticker';
    case Contact = 'contact';
    case InlineKeyboard = 'inline_keyboard';
    case ReplyKeyboard = 'reply_keyboard';
    case Location = 'location';
    case Share = 'share';
    case Data = 'data';

    /**
     * @return string value to camelCase.
     */
    function toCamelCase(): string
    {
        return lcfirst(preg_replace_callback('/_([a-z0-9])/', function ($matches) {
            return strtoupper($matches[1]);
        }, $this->value));
    }
}
