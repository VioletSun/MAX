<?php

namespace VioletSun\MAX\Objects;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use VioletSun\MAX\Enums\UpdateProcessingEnum;
use VioletSun\MAX\Enums\UpdateTypeEnum;
use VioletSun\MAX\Models\MaxUpdate;
use VioletSun\MAX\Models\MaxUser;

/**
 * TODO: сделать properties
 * @property ?Message $message
 * @property ?int $timestamp
 * @property ?string $user_locale
 * @property ?string $update_type
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

    public function saveData(?bool $enqueue = false): void
    {
        // Безопасный парсинг входных полей
        $message = $this->message;
        if (!$message) {
            return;
        }

        $recipient = $message->getObject('recipient');
        $sender = $message->getObject('sender');

        // TODO: тут не тот чат id может быть...
        // так как сообщение может быть не с диалога

        $chatId = $recipient?->getInt('chat_id');
        $userId = $sender?->getInt('user_id');

        if (!$chatId) {
            // Недостаточно данных — можно залогировать и выйти
            return;
        }

        // Подготовка данных пользователя
        $userData = [
            'chat_id'     => $chatId,
            'user_id'     => $userId,
            'first_name'  => $sender?->getString('first_name'),
            'last_name'   => $sender?->getString('last_name'),
            'username'    => $sender?->getString('name'),
            'last_active' => optional($sender?->getInt('last_activity_time')) // мс -> дата
                ? now()->createFromTimestampMs($sender->getInt('last_activity_time'))
                : now(),
            'active'      => true,
        ];

        // Тип апдейта
        $typeStr = $this->update_type ?? null;
        // Пытаемся привести к Enum. Если есть фабрика из строки — используйте её.
        $type = UpdateTypeEnum::tryFrom($typeStr) ?? $typeStr;

        // Оборачиваем в транзакцию для целостности
        DB::transaction(function () use ($chatId, $userId, $userData, $type, $enqueue) {
            // upsert пользователя
            // Вариант 1: updateOrCreate по (chat_id, user_id)
            MaxUser::query()->updateOrCreate(
                ['chat_id' => $chatId, 'user_id' => $userId],
                Arr::only($userData, [
                    'first_name', 'last_name', 'username', 'last_active', 'active',
                ])
            );

            // Подготовка данных апдейта
            $updatePayload =

            MaxUpdate::query()->create([
                'type'       => $type,
                'chat_id'    => $chatId,
                'user_id'    => $userId,
                'data'       => $this->toArray(), // или нормализовать, если нужно меньше данныхl
                'processing' => $enqueue ? UpdateProcessingEnum::InProgress : UpdateProcessingEnum::Backlog, // или ваш дефолт
            ]);
        });
    }

    public function enqueue(): void
    {
        // Если MaxUpdate уже создан в saveData и у вас есть его id — лучше диспатчить по id
        // Иначе — отправляем «сырые» данные
//        \VioletSun\MAX\Jobs\ProcessUpdate::dispatch($this->toArray())
//            ->onQueue('max-updates'); // имя очереди по вашему соглашению
    }
}
