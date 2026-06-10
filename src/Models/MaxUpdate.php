<?php

namespace VioletSun\MAX\Models;

use App\Enums\MaxUpdateProcessingEnum;
use App\Jobs\Max\MaxHandleCallback;
use App\Jobs\Max\MaxHandleMessage;
use App\Jobs\Max\MaxHandleOther;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use VioletSun\MAX\Models\Max\BotAddedToChatUpdate;
use VioletSun\MAX\Models\Max\BotRemovedFromChatUpdate;
use VioletSun\MAX\Models\Max\BotStartedUpdate;
use VioletSun\MAX\Models\Max\BotStoppedUpdate;
use VioletSun\MAX\Models\Max\ChatTitleChangedUpdate;
use VioletSun\MAX\Models\Max\ChatType;
use VioletSun\MAX\Models\Max\DialogClearedUpdate;
use VioletSun\MAX\Models\Max\DialogMutedUpdate;
use VioletSun\MAX\Models\Max\DialogRemovedUpdate;
use VioletSun\MAX\Models\Max\DialogUnmutedUpdate;
use VioletSun\MAX\Models\Max\MessageCallbackUpdate;
use VioletSun\MAX\Models\Max\MessageChatCreatedUpdate;
use VioletSun\MAX\Models\Max\MessageCreatedUpdate;
use VioletSun\MAX\Models\Max\MessageEditedUpdate;
use VioletSun\MAX\Models\Max\MessageRemovedUpdate;
use VioletSun\MAX\Models\Max\UpdateType;
use VioletSun\MAX\Models\Max\UserAddedToChatUpdate;
use VioletSun\MAX\Models\Max\UserRemovedFromChatUpdate;

/**
 * @property UpdateType $type
 * @property int $remote_chat_id
 * @property int $remote_user_id
 * @property array $data
 * @property MaxUpdateProcessingEnum $processing
 */
class MaxUpdate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'remote_chat_id',
        'remote_user_id',
        'data',
        'processing',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => UpdateType::class,
            'data' => 'array',
            'processing' => MaxUpdateProcessingEnum::class,
        ];
    }

    public static function boot(): void
    {
        parent::boot();
        self::creating(function (MaxUpdate $model) {
            if (empty($model->data)) {
                $model->data = [];
            }
        });
    }

    public function maxUser()
    {
        return $this->hasOne(MaxUser::class, '', 'remote_user_id');
    }

    /**
     * Get the prunable model query.
     */
    public function prunable(): Builder
    {
        return static::where('processing', MaxUpdateProcessingEnum::Done); // @phpstan-ignore-line
    }

    /**
     * Обработчик обновлений для разных типов событий:
     *
     * - BotAddedToChatUpdate       : Бот добавлен в чат
     * - BotRemovedFromChatUpdate   : Бот удалён из чата
     * - BotStartedUpdate           : Пользователь запустил бота
     * - BotStoppedUpdate           : Пользователь остановил бота
     * - ChatTitleChangedUpdate     : Заголовок чата изменился
     * - DialogClearedUpdate        : История диалогов очищена
     * - DialogMutedUpdate          : Уведомления отключены
     * - DialogRemovedUpdate        : Чат удалён
     * - DialogUnmutedUpdate        : Уведомления включены
     * - MessageCallbackUpdate      : Кнопка callback была нажата
     * - MessageChatCreatedUpdate   : Новый чат создан
     * - MessageCreatedUpdate       : Новое сообщение создано
     * - MessageEditedUpdate        : Сообщение было отредактировано
     * - MessageRemovedUpdate       : Сообщение удалено
     * - UserAddedToChatUpdate      : Пользователь добавлен в чат
     * - UserRemovedFromChatUpdate  : Пользователь удалён из чата
     *
     * @param BotAddedToChatUpdate|BotRemovedFromChatUpdate|BotStartedUpdate|BotStoppedUpdate|ChatTitleChangedUpdate|DialogClearedUpdate|DialogMutedUpdate|DialogRemovedUpdate|DialogUnmutedUpdate|MessageCallbackUpdate|MessageChatCreatedUpdate|MessageCreatedUpdate|MessageEditedUpdate|MessageRemovedUpdate|UserAddedToChatUpdate|UserRemovedFromChatUpdate $up
     * @return void
     */
    public static function set(mixed $up)
    {
        // dump($up);
        // return;

        if (self::handleSkip($up)) return;

        $remote_chat_id = self::handleRemoteChatId($up);
        $remote_user_id = self::handleRemoteUserId($up);
        $user = self::handleUser($up);

        MaxUser::set($user, $remote_chat_id);

        $maxUp = self::query()->create([
            'type' => $up->updateType,
            'remote_chat_id' => $remote_chat_id,
            'remote_user_id' => $remote_user_id,
            'data' => $up->toArray()
        ]);

        match ($up->updateType) {
            UpdateType::MessageCallback => dispatch(new MaxHandleCallback($maxUp)),

            UpdateType::MessageCreated,
            UpdateType::MessageEdited => dispatch(new MaxHandleMessage($maxUp)),

            default => dispatch(new MaxHandleOther($maxUp)),
        };
    }

    public static function handleSkip(mixed $up)
    {
        return match ($up->updateType) {
            UpdateType::MessageRemoved,
            UpdateType::DialogMuted,
            UpdateType::DialogUnmuted,
            UpdateType::DialogCleared,
            UpdateType::DialogRemoved // TODO: с этим разобраться..
            => true,
            default => false
        };
    }

    public static function handleRemoteChatId(mixed $up)
    {
        return match ($up->updateType) {
            UpdateType::BotStarted,
            UpdateType::BotStopped,
            UpdateType::UserRemoved
            => $up->chatId,

            UpdateType::MessageCreated
            => $up->message->recipient->chatId,

            default => null
        };
    }

    public static function handleRemoteUserId(mixed $up)
    {
        return match ($up->updateType) {
            UpdateType::BotStarted,
            UpdateType::BotStopped
            => $up->user->userId,

            UpdateType::MessageCreated
            => $up->message->recipient->chatType == ChatType::Dialog ? $up->message->sender->userId : null,

            UpdateType::UserRemoved
            => $up->user->userId,

            default => null
        };
    }

    public static function handleUser(mixed $up)
    {
        return match ($up->updateType) {
            UpdateType::BotStarted,
            UpdateType::BotStopped,
            UpdateType::UserRemoved
            => $up->user,

            UpdateType::MessageCreated
            => $up->message->sender,

            default => null
        };
    }
}
