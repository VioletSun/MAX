<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

/**
 * Describes possible events in a chat or channel.
 * @example https://dev.max.ru/docs-api/objects/Update
 */
enum UpdateTypeEnum: string
{
    /** Bot has been added to a chat or channel. */
    case BotAdded = 'bot_added';

    /**
     * User started communicating with the bot for the first time
     * or resumed after stopping by clicking the corresponding button in the bot settings in MAX.
     */
    case BotStarted = 'bot_started';

    /**
     * User stopped or deleted the bot through the bot settings in MAX.
     * In the latter case, the dialog_removed event is returned simultaneously with bot_stopped.
     */
    case BotStopped = 'bot_stopped';

    /** Bot has been removed from the chat or channel. */
    case BotRemoved = 'bot_removed';

    /** User changed the name of the chat or channel */
    case ChatTitleChanged = 'chat_title_changed';

    /** User cleared the chat history with the bot. */
    case DialogCleared = 'dialog_cleared';

    /** User disabled notifications in the dialogue with the bot. */
    case DialogMuted = 'dialog_muted';

    /** User enabled notifications in the dialogue with the bot */
    case DialogUnmuted = 'dialog_unmuted';

    /**
     * User deleted the conversation with the bot.
     * This event also returns bot_stopped — deleting the conversation automatically stops the bot.
     */
    case DialogRemoved = 'dialog_removed';

    /** User clicked a button in a chat or channel */
    case MessageCallback = 'message_callback';

    /** User sent a new message or published a post */
    case MessageCreated = 'message_created';

    /** User edited a message in a chat or channel */
    case MessageEdited = 'message_edited';

    /** User deleted the message from the chat or channel */
    case MessageRemoved = 'message_removed';

    /** New user has been added to the chat or channel or followed a link */
    case UserAdded = 'user_added';

    /** User has been deleted or left the chat or channel */
    case UserRemoved = 'user_removed';
}
