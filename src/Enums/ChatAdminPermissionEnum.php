<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

/**
 * Defines the permissions an administrator can have in a chat.
 * @link https://dev.max.ru/docs-api/methods/GET/chats/-chatId-/members/admins
 */
enum ChatAdminPermissionEnum: string
{
    case ReadAllMessages = 'read_all_messages';
    case AddRemoveMembers = 'add_remove_members';
    case AddAdmins = 'add_admins';
    case ChangeChatInfo = 'change_chat_info';
    case PinMessage = 'pin_message';
    case Write = 'write';
    case EditLink = 'edit_link';
    case Edit = 'edit';
    case Delete = 'delete';
    case CanCall = 'can_call';
    case ViewStats = 'view_stats';

    public function description(): string
    {
        return match ($this) {
            self::ReadAllMessages => 'Read all messages in a channel or group chat',
            self::AddRemoveMembers => 'Add and remove group chat participants or channel subscribers',
            self::AddAdmins => 'Add and remove administrators from a group chat or channel',
            self::ChangeChatInfo => 'Change information about a channel or group chat',
            self::PinMessage => 'Pin a message',
            self::Write => 'Edit and delete messages in group chats, as well as write posts in channels',
            self::EditLink => 'Change the link to a group chat (not available for channels)',
            self::Edit => 'Edit posts in channels',
            self::Delete => 'Delete posts',
            self::CanCall => 'Call in a group chat (not available for channels)',
            self::ViewStats => 'The right to view channel statistics (not available for group chats). This permission is assigned by default to channel owners. It is not available to other channel administrators or bots.',
        };
    }
}
