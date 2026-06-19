<?php

namespace VioletSun\MAX\Objects;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use VioletSun\MAX\Enums\UpdateProcessingEnum;
use VioletSun\MAX\Enums\UpdateTypeEnum;
use VioletSun\MAX\Models\MaxUpdate;
use VioletSun\MAX\Models\MaxUser;

/**
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

    public function saveData(?bool $enqueue = false): void
    {
        $chatId = $this->getChatId();
        $userId = $this->getUserId();
        $userData = $this->getUserData();

        $typeStr = $this->update_type ?? null;
        $type = UpdateTypeEnum::tryFrom($typeStr) ?? $typeStr;

        DB::transaction(function () use ($chatId, $userId, $userData, $type, $enqueue) {
            if (!empty($userData) && !empty($chatId) && !empty($userId)) {
                MaxUser::query()->updateOrCreate(
                    ['chat_id' => $chatId, 'user_id' => $userId],
                    Arr::only($userData, [
                        'first_name', 'last_name', 'username', 'last_active', 'active',
                    ])
                );
            }

            MaxUpdate::query()->create([
                'type'       => $type,
                'chat_id'    => $chatId,
                'user_id'    => $userId,
                'data'       => $this->toArray(),
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

    public function getChatId(): ?int
    {
        $message = $this->message;
        if ($message) {
            return null;
        }
        $recipient = $message->getObject('recipient');
        return $recipient?->getInt('chat_id');
    }

    public function getUserChatId(): ?int
    {
        $message = $this->message;
        if ($message) {
            return null;
        }
        $recipient = $message->getObject('recipient');
        return $recipient?->getInt('chat_id');
    }

    public function getUserId(): ?int
    {
        $message = $this->message;
        if ($message) {
            return null;
        }
        $sender = $message->getObject('sender');
        return $sender?->getInt('user_id');
    }

    public function getUserData(): ?array
    {
        $message = $this->message;
        if ($message) {
            return null;
        }

        $sender = $message->getObject('sender');
        return [
            'chat_id'     => $this->getUserChatId(),
            'user_id'     => $this->getUserId(),
            'first_name'  => $sender?->getString('first_name'),
            'last_name'   => $sender?->getString('last_name'),
            'username'    => $sender?->getString('name'),
            'last_active' => optional($sender?->getInt('last_activity_time')) // мс -> дата
                ? now()->createFromTimestampMs($sender->getInt('last_activity_time'))
                : now(),
            'active'      => true,
        ];
    }
}
