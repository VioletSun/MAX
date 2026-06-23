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

    public function buildMessage()
    {
        return MAX::builder();
    }
}
