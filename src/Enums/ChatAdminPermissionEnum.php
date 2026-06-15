<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

/**
 * Defines the permissions an administrator can have in a chat.
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
}
