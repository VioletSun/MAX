<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use VioletSun\MAX\Enums\ChatTypeEnum;
use VioletSun\MAX\Enums\UpdateProcessingEnum;
use VioletSun\MAX\Enums\UpdateTypeEnum;
use VioletSun\MAX\Facades\MAX;
use VioletSun\MAX\Models\MaxChat;
use VioletSun\MAX\Models\MaxUpdate;
use VioletSun\MAX\Models\MaxUser;
use VioletSun\MAX\Objects\Callback\Callback;
use VioletSun\MAX\Objects\Common\User;
use VioletSun\MAX\Objects\Message\Message;
use VioletSun\MAX\Support\BaseObject;

/**
 * TODO: сделать isChannel, isDialog
 * @property UpdateTypeEnum $update_type
 * @property Message|null $message
 * @property bool|null $is_channel
 * @property User|null $user
 * @property Callback|null $callback
 */
final class Update extends BaseObject
{
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

    public function saveData(?bool $enqueue = false): void
    {
        $chatId = $this->getChatId();
        $chatUserId = $this->getUserChatId();
        $userData = $this->getUserData();
        $userId = $userData['user_id'] ?? null;
        $type = $this->update_type;

        DB::transaction(function () use ($chatId, $chatUserId, $userId, $userData, $type, $enqueue) {
            // MaxUser
            $max_user = null;
            if (!empty($userData) && !empty($chatUserId) && !empty($userId)) {
                $datum = [];
                foreach ($userData as $key => $val) {
                    if (is_null($val)) continue;
                    if ($key == 'private' && $val === false) continue;
                    $datum[$key] = $val;
                }
                $max_user = MaxUser::query()->updateOrCreate(
                    ['chat_id' => $chatUserId, 'user_id' => $userId],
                    Arr::only($datum, [
                        'first_name', 'last_name', 'username', 'last_active', 'avatar_url', 'full_avatar_url', 'private', 'last_active'
                    ])
                );
            }


            $max_chat = null;
            if ($chatId < 0 && $type == UpdateTypeEnum::BotAdded) {
                $responseChat = MAX::getChat($chatId);
                $max_chat = MaxChat::query()->updateOrCreate(
                    ['chat_id' => $responseChat->chat_id],
                    Arr::only($datum, [
                        'type','status','title','last_event_time','participants_count','is_public','link','messages_count',
                    ])
                );
                if (!is_null($max_chat)) {
                    $max_chat->maxUsers()->attach($max_user);
                }
            }

            // MaxChat
            // if "update_type": "bot_added"
            // узнаем всё про то, куда нас добавили
            // создаём запись в бд

            // MaxChat & MaxUser => MaxUser to MaxChat

            // MaxUpdate
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
