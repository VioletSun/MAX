<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum Action: string
{
    case ME = '/me';
    case SUBSCRIPTIONS = '/subscriptions';
    case MESSAGES = '/messages';
    case UPLOADS = '/uploads';
    case CHATS = '/chats';
    case CHATS_ACTIONS = '/chats/%d/actions';
    case CHATS_PIN = '/chats/%d/pin';
    case CHATS_MEMBERS_ME = '/chats/%d/members/me';
    case CHATS_MEMBERS_ADMINS = '/chats/%d/members/admins';
    case CHATS_MEMBERS_ADMINS_ID = '/chats/%d/members/admins/%d';
    case CHATS_MEMBERS = '/chats/%d/members';
    case UPDATES = '/updates';
    case ANSWERS = '/answers';
    case VIDEO_DETAILS = '/videos/%s';
}
