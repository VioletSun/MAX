<?php

namespace VioletSun\MAX\Objects;

class Message extends BaseObject
{
    protected static array $schema = [
        'recipient' => Recipient::class,
        'sender' => Sender::class,
        'body' => Body::class,
    ];
    public function recipient(): ?Recipient { return $this->get('recipient'); }
    public function sender(): ?Sender { return $this->get('sender'); }
    public function body(): ?Body { return $this->get('body'); }
    public function timestamp(): ?int { return $this->getInt('timestamp'); }
}
