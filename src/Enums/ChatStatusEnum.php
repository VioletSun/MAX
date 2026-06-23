<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

/**
 * @link https://dev.max.ru/docs-api/methods/GET/chats/-chatId-
 */
enum ChatStatusEnum: string
{
    /** The bot is an active participant in the chat */
    case Active = 'active';
    /** The bot has been removed from the chat. */
    case Removed = 'removed';
    /** The bot has left the chat */
    case Left = 'left';
    /** Chat has been closed */
    case Closed = 'closed';
}
