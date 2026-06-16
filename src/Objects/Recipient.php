<?php

namespace VioletSun\MAX\Objects;

class Recipient extends BaseObject
{
    protected static array $schema = [];
    // геттеры по желанию
    public function chatId(): ?int { return $this->getInt('chat_id'); }
    public function chatType(): ?string { return $this->getString('chat_type'); }
    public function userId(): ?int { return $this->getInt('user_id'); }
}
