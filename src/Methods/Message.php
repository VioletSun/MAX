<?php

namespace VioletSun\MAX\Methods;

use VioletSun\MAX\Client;

/**
 * Class Message.
 *
 * @mixin Client
 */
trait Message
{
    /**
     * Send text messages.
     *
     * <code>
     * $data = [
     *     'text' => '',  // string     - Required. Text of the message to be sent
     * ]
     * </code>
     *
     * @link https://dev.max.ru/docs-api/methods/POST/messages
     */

    public function sendMessage(int|string $chat_id, array $data): array
    {
        return $this->client->post("messages", $data, ["chat_id" => $chat_id]);
    }
}
