<?php

namespace VioletSun\MAX\Methods;

use VioletSun\MAX\Client;
use VioletSun\MAX\Enums\UpdateTypeEnum;
use VioletSun\MAX\Objects\Me;
use VioletSun\MAX\Objects\Updates;
use VioletSun\MAX\Objects\Chat\Chat as ObjectChat;

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
    public function getChat(int|string $chat_id): ObjectChat
    {
        return ObjectChat::fromArray($this->client->get("/chats/{$chat_id}"));
    }
}
