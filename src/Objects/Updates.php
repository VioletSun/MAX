<?php

namespace VioletSun\MAX\Objects;

/**
 * @property Update[] $updates
 * @property int $marker
 * @property ?bool $save_data
 * @property ?bool $enqueue
 */
class Updates extends BaseObject
{
    protected static array $schema = [
        'updates[]' => Update::class, // список апдейтов
    ];

    public function handleData()
    {
        $save = $this->getBool('save_data', false) ?? false;
        $enqueue = $this->getBool('enqueue', false) ?? false;

        $updates = is_array($this->updates) ? $this->updates : $this;
        if ($updates) {
            foreach ($updates as $update) {
                if (!$update instanceof Update) {
                    continue; // protection if someone slips in a non-Update
                }

                try {
                    if ($save) {
                        $update->saveData($enqueue);
                    }
                    if ($enqueue) {
                        $update->enqueue();
                    }
                } catch (\Throwable $e) {
                    // логируем и продолжаем
                    // logger()->error('Update processing failed', ['e' => $e, 'update' => $update]);
                }
            }
        }
    }
}
