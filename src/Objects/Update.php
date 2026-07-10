<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects;

use Illuminate\Support\Arr;
use VioletSun\MAX\Enums\ChatStatusEnum;
use VioletSun\MAX\Enums\ChatTypeEnum;
use VioletSun\MAX\Enums\UpdateProcessingEnum;
use VioletSun\MAX\Enums\UpdateTypeEnum;
use VioletSun\MAX\Facades\MAX;
use App\Models\Max\MaxChat;
use App\Models\Max\MaxUpdate;
use App\Models\Max\MaxUser;
use VioletSun\MAX\Objects\Callback\Callback;
use VioletSun\MAX\Objects\Common\User;
use VioletSun\MAX\Objects\Message\Message;
use VioletSun\MAX\Support\BaseObject;

/**
 * @property UpdateTypeEnum $update_type
 * @property Message|null $message
 * @property bool|null $is_channel
 * @property User|null $user
 * @property Callback|null $callback
 */
final class Update extends BaseObject
{
    public MaxUser|null $maxUser = null;
    public MaxUpdate|null $maxUpdate = null;
    public MaxChat|null $maxChat = null;

    public static function fromArray(array $data): static
    {
        $type = UpdateTypeEnum::tryFrom($data['update_type']);
        $mapped = [
            'update_type' => $type,
            'timestamp' => $data['timestamp'] ?? null,
            'user_locale' => $data['user_locale'] ?? null,

        ];

        // Вариативные поля
        switch ($type) {
            case UpdateTypeEnum::BotStarted:
            case UpdateTypeEnum::BotStopped:
            case UpdateTypeEnum::BotAdded:
            case UpdateTypeEnum::BotRemoved:
            case UpdateTypeEnum::ChatTitleChanged:
            case UpdateTypeEnum::DialogCleared:
            case UpdateTypeEnum::DialogMuted:
            case UpdateTypeEnum::DialogUnmuted:
            case UpdateTypeEnum::DialogRemoved:
                if (isset($data['user'])) {
                    $mapped['user'] = User::fromArray($data['user']);
                }
                if (array_key_exists('chat_id', $data)) {
                    $mapped['chat_id'] = $data['chat_id'];
                }
                break;

            case UpdateTypeEnum::MessageCreated:
            case UpdateTypeEnum::MessageEdited:
            case UpdateTypeEnum::MessageRemoved:
                if (isset($data['message'])) {
                    $mapped['message'] = Message::fromArray($data['message']);
                }
                break;

            case UpdateTypeEnum::MessageCallback:
                if (isset($data['callback'])) {
                    $mapped['callback'] = Callback::fromArray($data['callback']);
                }
                if (isset($data['message'])) {
                    $mapped['message'] = Message::fromArray($data['message']);
                }
                break;

            case UpdateTypeEnum::UserAdded:
            case UpdateTypeEnum::UserRemoved:
                if (isset($data['user'])) {
                    $mapped['user'] = User::fromArray($data['user']);
                }
                if (array_key_exists('chat_id', $data)) {
                    $mapped['chat_id'] = $data['chat_id'];
                }
                if (array_key_exists('user_id', $data)) {
                    $mapped['user_id'] = $data['user_id']; // субъект события
                }
                if (array_key_exists('is_channel', $data)) {
                    $mapped['is_channel'] = (bool)$data['is_channel'];
                }
                if (array_key_exists('admin_id', $data)) {
                    $mapped['admin_id'] = $data['admin_id'];
                }
                break;
        }

        return new self($mapped);
    }

    public function type(): ?UpdateTypeEnum
    {
        return $this->update_type ?? null;
    }

    public function saveData(?bool $enqueue = false): static
    {
        $chatId = $this->getChatId();
        $chatUserId = $this->getUserChatId();
        $userData = $this->userDataHandleToDB();
        $userId = $userData['user_id'] ?? null;
        $type = $this->update_type;

        // MaxUser
        if (!empty($userData) && !empty($chatUserId) && !empty($userId)) {
            $this->maxUser = MaxUser::query()->updateOrCreate(
                ['chat_id' => $chatUserId, 'user_id' => $userId],
                Arr::only($userData, [
                    'first_name', 'last_name', 'username', 'last_active', 'avatar_url', 'full_avatar_url', 'last_active'
                ])
            );
        } elseif (!empty($userData) && empty($chatUserId) && !empty($userId)) {
            $this->maxUser = MaxUser::query()->updateOrCreate(
                ['user_id' => $userId],
                Arr::only($userData, [
                    'first_name', 'last_name', 'username', 'last_active', 'avatar_url', 'full_avatar_url', 'last_active'
                ])
            );
        }
        if ($type === UpdateTypeEnum::BotStarted && $this->maxUser) {
            $this->maxUser->update(['private' => true]);
        } elseif ($type === UpdateTypeEnum::BotStopped && $this->maxUser) {
            $this->maxUser->update(['private' => false]);
        }

        // MaxChat
        if ($chatId < 0 && $type == UpdateTypeEnum::BotAdded) {
            $chatInfo = MAX::chatInfo($chatId);
            $this->maxChat = MaxChat::query()->updateOrCreate(
                ['chat_id' => $chatInfo->chat_id],
                $chatInfo->only([
                    'type','status','title','last_event_time','participants_count','is_public','link','messages_count',
                ])->toArray()
            );
        } elseif ($chatId < 0 && $type == UpdateTypeEnum::BotRemoved) {
            MaxChat::query()->where('chat_id', $chatId)->update(['status' => ChatStatusEnum::Removed]);
        } elseif ($chatId < 0) {
            $this->maxChat = MaxChat::query()->where('chat_id', $chatId)->first();
        }
        if ($type == UpdateTypeEnum::UserAdded && $this->maxChat && $this->maxUser && $this->maxChat->maxUsers()->where('user_id', $chatUserId)->doesntExist()) {
            $this->maxChat->maxUsers()->attach($this->maxUser);
        } elseif ($type == UpdateTypeEnum::UserRemoved && $this->maxChat && $this->maxUser) {
            $this->maxChat->maxUsers()->detach($this->maxUser);
        }

        // MaxUpdate
        $this->maxUpdate = MaxUpdate::query()->create([
            'type'       => $type,
            'chat_id'    => $chatId,
            'user_id'    => $userId,
            'data'       => $this->toArray(),
            'processing' => $enqueue ? UpdateProcessingEnum::InProgress : UpdateProcessingEnum::Backlog
        ]);
        return $this;
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
        return $this?->chat_id ?? $this?->message?->recipient?->chat_id ?? null;
    }

    public function getUserChatId(): ?int
    {
        return $this->isDialog() ? $this->getChatId() : null;
    }

    public function getUserId(): ?int
    {
        return null;
    }

    public function getUserData(): ?array
    {
        if ($this->user instanceof User) {
            return $this->user->toArray();
        }

        if (!$this->isDialog()) {
            return null;
        }

        if (
            !empty($this->type()) &&
            in_array(
                $this->type(), [
                    UpdateTypeEnum::BotStarted,
                    UpdateTypeEnum::BotStopped
                ]
            )
        ) {
            $user = $this->user;
        } elseif ($this?->message?->sender && !$this->isCallback()) {
            $user = $this->message->sender;
        } elseif ($this->isCallback()) {
            $user = $this->callback->user;
        } else {
            return null;
        }

        if ($user->is_bot) {
            return null;
        }

        return [
            'chat_id'     => $this->getUserChatId(),
            'user_id'     => $user->int('user_id'),
            'first_name'  => $user->str('first_name'),
            'last_name'   => $user->str('last_name'),
            'username'    => $user->str('name'),
            'avatar_url'    => $user->str('avatar_url'),
            'full_avatar_url'    => $user->str('full_avatar_url'),
            'last_active' => $user->last_activity_time,
            'private'     => $this->isDialog(),
        ];
    }

    public function userDataHandleToDB(): ?array
    {
        $datum = [];
        if ($userData = $this->getUserData()) {
            foreach ($userData as $key => $val) {
                if (is_null($val)) continue;
                if ($key == 'private' && $val === false) continue;
                $datum[$key] = $val;
            }
        }
        return $datum;
    }

    public function isDialog(): bool
    {
        if (
            (($chat_type = $this?->message?->recipient?->chat_type ?? null) && $chat_type === ChatTypeEnum::Dialog) ||
            (
                !empty($this->type()) &&
                in_array(
                    $this->type(), [
                        UpdateTypeEnum::BotStarted,
                        UpdateTypeEnum::BotStopped,
                    ]
                )
            )
        ) {
            return true;
        }
        return false;
    }

    public function isChannel(): bool
    {
        if (
            $this->is_channel === true ||
            (($chat_type = $this?->message?->recipient?->chat_type ?? null) && $chat_type === ChatTypeEnum::Channel)
        ) {
            return true;
        }
        return false;
    }

    public function isCallback(): bool
    {
        return $this->type() === UpdateTypeEnum::MessageCallback;
    }
}
