<?php

namespace VioletSun\MAX\Methods;

use Illuminate\Support\Str;
use VioletSun\MAX\Builder\MessageBuilder;
use VioletSun\MAX\Client;
use VioletSun\MAX\Enums\MessageFormatEnum;
use VioletSun\MAX\Objects\AbstractObject;

/**
 * Class Message.
 *
 * @mixin Client
 */
trait Message
{
    /**
     * Send messages.
     *
     * <code>
     * $data = [
     *     'text' => '',                         // string   - Required. Text of the message to be sent, up to 4000 characters
     *     'disable_link_preview' => false,      // bool     - Generate previews for links. Default: false
     *     'notify' => true,                     // bool     - Delivery notification to the user
     *     'attachments' => AttachmentRequest[], // object   - AttachmentRequest[]
     *     'format' => MessageFormatEnum::Html,  // enum     - MessageFormatEnum
     * ]
     * </code>
     *
     * @link https://dev.max.ru/docs-api/methods/POST/messages
     */

    public function sendMessage(int|string $chat_id, array $data): AbstractObject
    {
        return AbstractObject::fromArray($this->client->post("messages", $this->handleData($data), ["chat_id" => $chat_id]));
    }

    /**
     * Edit messages.
     *
     * <code>
     * $data = [
     *     'text' => '',                         // string   - Required. Text of the message to be sent, up to 4000 characters
     *     'disable_link_preview' => false,      // bool     - Generate previews for links. Default: false
     *     'notify' => true,                     // bool     - Delivery notification to the user
     *     'attachments' => AttachmentRequest[], // object   - AttachmentRequest[]
     *     'format' => MessageFormatEnum::Html,  // enum     - MessageFormatEnum
     * ]
     * </code>
     *
     * @link https://dev.max.ru/docs-api/methods/PUT/messages
     */
    public function editMessage(int|string $message_id, array $data): array
    {
        return $this->client->put("messages", $this->handleData($data), ["message_id" => $message_id]);
    }

    /**
     * Delete messages.
     *
     * @link https://dev.max.ru/docs-api/methods/DELETE/messages
     */
    public function deleteMessage(int|string $message_id): array
    {
        return $this->client->delete("messages", ["message_id" => $message_id]);
    }

    private function handleData(array $data): array
    {
        if (!empty($data['text'])) {
            $data['text'] = Str::limit($data['text'], 4000);
        }
        if (!isset($data['disable_link_preview'])) {
            $data['disable_link_preview'] = false;
        }
        if (!isset($data['format'])) {
            $data['format'] = MessageFormatEnum::Html->value;
        } elseif($data['format'] instanceof MessageFormatEnum) {
            $data['format'] = $data['format']->value;
        }
        return $data;
    }

    public function builder(): MessageBuilder
    {
        return new MessageBuilder();
    }
}
