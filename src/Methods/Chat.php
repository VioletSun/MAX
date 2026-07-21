<?php

declare(strict_types=1);

namespace VioletSun\MAX\Methods;

use VioletSun\MAX\Client;
use VioletSun\MAX\Enums\ChatActionEnum;
use VioletSun\MAX\Enums\ChatAdminPermissionEnum;
use VioletSun\MAX\Objects\AbstractObject;
use VioletSun\MAX\Objects\Chat\ChatIcon;
use VioletSun\MAX\Objects\Chat\Chat as ObjectChat;
use VioletSun\MAX\Objects\Chat\Member;
use VioletSun\MAX\Objects\Message\Message;
use VioletSun\MAX\Support\BaseObject;

/**
 * Class Get.
 *
 * @mixin Client
 */
trait Chat
{
    /**
     * Getting information in a group chat or channel
     *
     * @link https://dev.max.ru/docs-api/methods/GET/chats/-chatId-
     */
    public function chatInfo(int|string $chat_id): ObjectChat
    {
        return ObjectChat::fromArray($this->client->get("/chats/{$chat_id}"));
    }

    /**
     * Changing information about a group chat or channel
     *
     * @param int|string $chat_id
     * @param ChatIcon|null $icon
     * @param string|null $title
     * @param string|int|null $pin
     * @param bool|null $notify
     * @return ObjectChat
     *
     * @link https://dev.max.ru/docs-api/methods/PATCH/chats/-chatId-
     */
    public function chatEdit(int|string $chat_id, ?ChatIcon $icon = null, ?string $title = null, string|int|null $pin = null, ?bool $notify = true): ObjectChat
    {
        $data['notify'] = $notify;
        if (!empty($icon)) {
            $data['icon'] = $icon;
        }
        if (!empty($title)) {
            $data['title'] = $title;
        }
        if (!empty($pin)) {
            $data['pin'] = $pin;
        }
        return ObjectChat::fromArray($this->client->patch("/chats/{$chat_id}", $data));
    }

    /**
     * Sending a bot action in a group chat
     *
     * @param int|string $chat_id
     * @param ChatActionEnum $action
     * @return BaseObject
     *
     * @link https://dev.max.ru/docs-api/methods/POST/chats/-chatId-/actions
     */
    public function chatAction(int|string $chat_id, ChatActionEnum $action): BaseObject
    {
        return AbstractObject::fromArray($this->client->post("/chats/{$chat_id}/actions", ['action' => $action->value]));
    }

    /**
     * Receiving a pinned message in a group chat or channel
     *
     * @link https://dev.max.ru/docs-api/methods/GET/chats/-chatId-/pin
     */
    public function chatPins(int|string $chat_id): AbstractObject
    {
        $rows = AbstractObject::fromArray($this->client->get("/chats/{$chat_id}/pin"));
        if (is_null($rows->status)) {
            $array = [];
            foreach ($rows as $row) {
                $array[] = Message::fromArray($row);
            }
            $rows = AbstractObject::fromArray($array);
        }
        return $rows;
    }

    /**
     * Pinning a message to a group chat or channel
     *
     * @param int|string $chat_id
     * @param int|string $message_id
     * @param bool|null $notify
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/PUT/chats/-chatId-/pin
     */
    public function chatPin(int|string $chat_id, int|string $message_id, ?bool $notify = true): AbstractObject
    {
        return AbstractObject::fromArray($this->client->put("/chats/{$chat_id}/pin", compact('message_id', 'notify')));
    }

    /**
     * Unpinning a message in a group chat or channel
     *
     * @param int|string $chat_id
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/DELETE/chats/-chatId-/pin
     */
    public function chatPinDelete(int|string $chat_id): AbstractObject
    {
        return AbstractObject::fromArray($this->client->delete("/chats/{$chat_id}/pin"));
    }

    /**
     * Getting information about a bot's membership in a group chat or channel
     *
     * @param int|string $chat_id
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/GET/chats/-chatId-/members/me
     */
    public function chatMeInfo(int|string $chat_id): AbstractObject
    {
        return AbstractObject::fromArray($this->client->get("/chats/{$chat_id}/members/me"));
    }

    /**
     * Removing a bot from a group chat or channel
     *
     * @param int|string $chat_id
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/DELETE/chats/-chatId-/members/me
     */
    public function chatMeDelete(int|string $chat_id): AbstractObject
    {
        return AbstractObject::fromArray($this->client->delete("/chats/{$chat_id}/members/me"));
    }

    /**
     * Getting a list of admins for a group chat or channel
     *
     * @param int|string $chat_id
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/GET/chats/-chatId-/members/admins
     */
    public function chatAdmins(int|string $chat_id): AbstractObject
    {
        $request = AbstractObject::fromArray($this->client->get("/chats/{$chat_id}/members/admins"));
        if (!$request->members) {
            return $request;
        }

        $members = [];
        foreach ($request->members as $member) {
            $members[] = Member::fromArray($member);
        }
        return AbstractObject::fromArray([
            'marker' => $response->members ?? null,
            'members' => $members
        ]);
    }

    /**
     * Assign an administrator to a group chat or channel
     *
     * @param int|string $chat_id
     * @param array $admins
     * @param int|null $marker
     * @return AbstractObject
     *
     * <code>
     * $admins = [
     *  [
     *      "user_id" => "{user_id}",
     *      "permissions" => [
     *          ChatAdminPermissionEnum::Permission,
     *          ChatAdminPermissionEnum::Permission
     *      ],
     *      "alias" => "",
     *  ]
     * ]
     * </code>
     * @link https://dev.max.ru/docs-api/methods/POST/chats/-chatId-/members/admins
     */
    public function chatSetAdmin(int|string $chat_id, array $admins, ?int $marker = null): AbstractObject
    {
        return AbstractObject::fromArray($this->client->post("/chats/{$chat_id}/members/admins"));
    }

    /**
     * Revoke admin rights in a group chat or channel
     *
     * @param int|string $chat_id
     * @param int|string $user_id
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/DELETE/chats/-chatId-/members/admins/-userId-
     */
    public function chatRevokeAdmin(int|string $chat_id, int|string $user_id): AbstractObject
    {
        return AbstractObject::fromArray($this->client->delete("/chats/{$chat_id}/members/admins/{$user_id}"));
    }

    /**
     * Getting members of a group chat or channel
     *
     * @param int|string $chat_id
     * @param array|null $user_ids
     * @param int|null $marker
     * @param int|null $count
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/GET/chats/-chatId-/members
     */
    public function chatMembers(int|string $chat_id, ?array $user_ids = [], ?int $marker = null, ?int $count = 20): AbstractObject
    {
        $data = [];
        if (!empty($user_ids)) {
            $data['user_ids'] = $user_ids;
        }
        if (!empty($marker)) {
            $data['marker'] = $marker;
        }
        if (!empty($count)) {
            $data['count'] = $count;
        }
        $response = AbstractObject::fromArray($this->client->get("/chats/{$chat_id}/members", $data));
        $members = [];
        foreach ($response->members ?? [] as $member) {
            $members[] = Member::fromArray($member);
        }
        return AbstractObject::fromArray([
            'marker' => $response->members ?? null,
            'members' => $members
        ]);
    }

    /**
     * Adding members to a group chat or channel
     *
     * @param int|string $chat_id
     * @param array $user_ids
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/POST/chats/-chatId-/members
     */
    public function chatBulkMembers(int|string $chat_id, array $user_ids): AbstractObject
    {
        return AbstractObject::fromArray($this->client->post("/chats/{$chat_id}/members", ['user_ids' => $user_ids]));
    }

    /**
     * Removing a member from a group chat or channel
     *
     * @link https://dev.max.ru/docs-api/methods/DELETE/chats/-chatId-/members
     */
    public function chatDeleteMember(int|string $chat_id, int|string $user_id, ?bool $block = true): AbstractObject
    {
        $query_block = $block ? '&block=true' : '';
        return AbstractObject::fromArray($this->client->delete("/chats/{$chat_id}/members?user_id={$user_id}{$query_block}"));
    }
}
