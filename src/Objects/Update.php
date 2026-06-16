<?php

namespace VioletSun\MAX\Objects;

class Update extends BaseObject
{
    protected static array $schema = [
        'message' => Message::class,
    ];
    public function message(): ?Message { return $this->get('message'); }
    public function timestamp(): ?int { return $this->getInt('timestamp'); }
    public function userLocale(): ?string { return $this->getString('user_locale'); }
    public function updateType(): ?string { return $this->getString('update_type'); }

}
