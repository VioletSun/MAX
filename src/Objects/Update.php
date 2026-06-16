<?php

namespace VioletSun\MAX\Objects;

/**
 * TODO: сделать properties
 */
class Update extends BaseObject
{
    protected static array $schema = [
        'message' => Message::class,
    ];

    /**
     * TODO: сделать isChannel, isDialog
     * TODO: update_type в Enum
     */

    /**
     * TODO: при создании этого объекта проверять, есть ли мы в БД...
     * если настройки включены для сохранения данных в БД MAX_SAVE_DATA
     */

    /**
     * TODO: убрать
     */
    public function message(): ?Message { return $this->get('message'); }
    public function timestamp(): ?int { return $this->getInt('timestamp'); }
    public function userLocale(): ?string { return $this->getString('user_locale'); }
    public function updateType(): ?string { return $this->getString('update_type'); }

}
