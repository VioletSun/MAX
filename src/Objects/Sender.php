<?php

namespace VioletSun\MAX\Objects;

class Sender extends BaseObject
{
    protected static array $schema = [];

    /**
     * TODO: при создании этого объекта проверять, есть ли мы в БД...
     * если настройки включены для сохранения данных в БД MAX_SAVE_DATA
     */

    public function userId(): ?int { return $this->getInt('user_id'); }
    public function firstName(): ?string { return $this->getString('first_name'); }
    public function lastName(): ?string { return $this->getString('last_name'); }
    public function isBot(): ?bool { return $this->getBool('is_bot'); }
    public function lastActivityTime(): ?int { return $this->getInt('last_activity_time'); }
    public function name(): ?string { return $this->getString('name'); }
}
