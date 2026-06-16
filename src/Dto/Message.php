<?php

namespace VioletSun\MAX\Dto;

class Message extends BaseObject
{
    protected static array $schema = [
        'recipient' => Recipient::class,
        'sender' => Sender::class,
        'body' => Body::class,
    ];
    public function recipient(): \Closure
    { return $this->get('recipient'); }
    public function sender(): \Closure
    { return $this->get('sender'); }
    public function body(): \Closure
    { return $this->get('body'); }
    public function timestamp(): ?int { return $this->getInt('timestamp'); }
}
