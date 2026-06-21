<?php

namespace VioletSun\MAX\Methods;

use Illuminate\Support\Str;
use VioletSun\MAX\Client;
use VioletSun\MAX\Enums\MessageFormatEnum;

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

    public function sendMessage(int|string $chat_id, array $data): array
    {
        $data['text'] = Str::limit($data['text'], 4000);
        if (!isset($data['disable_link_preview'])) {
            $data['disable_link_preview'] = false;
        }
        if (!isset($data['format'])) {
            $data['format'] = MessageFormatEnum::Html->value;
        } elseif($data['format'] instanceof MessageFormatEnum) {
            $data['format'] = $data['format']->value;
        }
        return $this->client->post("messages", $data, ["chat_id" => $chat_id]);
    }
}
