<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

/**
 * Represents the different actions a bot can send to a chat to indicate its status.
 */
enum SenderAction: string
{
    case TypingOn = 'typing_on';
    case SendingPhoto = 'sending_photo';
    case SendingVideo = 'sending_video';
    case SendingAudio = 'sending_audio';
    case SendingFile = 'sending_file';
    case MarkSeen = 'mark_seen';
}
