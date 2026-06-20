<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects;

use VioletSun\MAX\Support\BaseObject;

/**
 * @property Update[] $updates
 * @property int $marker
 * @property ?bool $save_data
 * @property ?bool $enqueue
 */
final class Updates extends BaseObject
{
    /**
     * Создает Updates из входящего webhook payload.
     */
    public static function fromArray(array $data): static
    {
        $updatesRaw = $data['updates'] ?? [];
        $updates = array_map(fn(array $u) => Update::fromArray($u), $updatesRaw);
        $object = new self([
            'save_data' => $data['save_data'] ?? false,
            'enqueue' => $data['enqueue'] ?? false,
            'marker' => $data['marker'] ?? null,
            'updates' => $updates,
        ]);
        $object->handleData();
        return $object;
    }

    public function handleData(): void
    {
        $save = $this->bool('save_data', false);
        $enqueue = $this->bool('enqueue', false);

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
