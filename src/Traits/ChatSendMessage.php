<?php

namespace VioletSun\MAX\Traits;

use VioletSun\MAX\Facades\MAX;

trait ChatSendMessage
{
    public function sendMessage(array $data)
    {
        if (!empty($this->chat_id)) {
            return MAX::sendMessage($this->chat_id, $data);
        }
        return null;
    }

    public function buildMessage($set_chat_id = true)
    {
        $max = MAX::builder();
        if ($set_chat_id) {
            $max->chatId($this->chat_id);
        }
        return $max;
    }
}
