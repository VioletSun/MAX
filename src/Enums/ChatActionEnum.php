<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

/**
 * @link https://dev.max.ru/docs-api/methods/POST/chats/-chatId-/actions#%D0%A2%D0%B5%D0%BB%D0%BE%20%D0%B7%D0%B0%D0%BF%D1%80%D0%BE%D1%81%D0%B0
 */
enum ChatActionEnum: string
{
    case TypingOn = 'typing_on';
    case SendingPhoto = 'sending_photo';
    case SendingVideo = 'sending_video';
    case SendingAudio = 'sending_audio';
    case SendingFile = 'sending_file';
}
