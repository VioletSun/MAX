# Message Builder

`MessageBuilder` — fluent-интерфейс для создания, отправки, редактирования и удаления сообщений MAX.

Builder позволяет удобно собирать сообщение цепочкой методов, добавлять вложения и inline-клавиатуры без ручной подготовки массива `attachments`.

## Быстрый пример
```php
use VioletSun\MAX\Builder\AttachmentsBuilder; use VioletSun\MAX\Facades\MAX;
MAX::builder() ->chatId(1234567890) ->text('Привет! Это сообщение отправлено через MessageBuilder.') ->attachments(function (AttachmentsBuilder builder) {builder->inlineKeyboard; }) ->send();
```

## Создание builder

Builder доступен через фасад `MAX`:
```php
MAX::builder();
```
Метод возвращает экземпляр `VioletSun\MAX\Builder\MessageBuilder`.

## Отправка сообщения

Для отправки сообщения необходимо указать `chat_id`.
```php
MAX::builder() ->chatId(1234567890) ->text('Текст сообщения') ->send();
```

Если `chat_id` не указан, будет выброшено исключение.

## Редактирование сообщения

Для редактирования сообщения необходимо указать `message_id`.
```php
MAX::builder() ->messageId('MESSAGE_ID') ->text('Обновлённый текст сообщения') ->edit();
```

Если `message_id` не указан, будет выброшено исключение.

## Удаление сообщения
```php
MAX::builder() ->messageId('MESSAGE_ID') ->delete();
```

## Доступные методы MessageBuilder

### `chatId(int $chat_id)`

Устанавливает идентификатор чата, в который будет отправлено сообщение.
```php
MAX::builder() ->chatId(1234567890);
```

### `messageId(string $message_id)`

Устанавливает идентификатор сообщения для редактирования или удаления.
```php
MAX::builder() ->messageId('MESSAGE_ID');
```

### `text(string $text)`

Устанавливает текст сообщения.
```php
MAX::builder() ->text('Текст сообщения');
```

### `disableLinkPreview()`

Отключает предпросмотр ссылок в сообщении.
```php
MAX::builder() ->chatId(1234567890) ->text('https://max.ru') ->disableLinkPreview() ->send();
```

### `attachments(callable $callback)`

Добавляет вложения к сообщению через `AttachmentsBuilder`.

```php
use VioletSun\MAX\Builder\AttachmentsBuilder;
MAX::builder() ->chatId(1234567890) ->text('Сообщение с вложениями') ->attachments(function (AttachmentsBuilder builder) {builder->image(token: 'IMAGE_TOKEN'); }) ->send();
```

### `send()`

Отправляет сообщение.
```php
MAX::builder() ->chatId(1234567890) ->text('Сообщение') ->send();
```

### `edit()`

Редактирует сообщение.
```php
MAX::builder() ->messageId('MESSAGE_ID') ->text('Новый текст') ->edit();
```

### `delete()`

Удаляет сообщение.
```php
MAX::builder() ->messageId('MESSAGE_ID') ->delete();
```

### `dump()`

Выводит текущее состояние builder через Laravel `dump()` и возвращает текущий экземпляр builder.
```php
MAX::builder() ->chatId(1234567890) ->text('Debug message') ->dump()
```

## AttachmentsBuilder

`AttachmentsBuilder` используется внутри метода `attachments()` и позволяет добавлять к сообщению разные типы вложений.

```php
MAX::builder() ->chatId(1234567890) ->attachments(function (AttachmentsBuilder builder) {builder->image(token: 'IMAGE_TOKEN'); $builder->sticker(code: 'STICKER_CODE'); }) ->send();
```

## Изображение

Изображение можно добавить по токену, массиву `photos`, URL или локальному файлу.
```php
// По токену
$builder->image(token: 'IMAGE_TOKEN');
// Список, По токену
$builder->image(photos: ['IMAGE_TOKEN', 'IMAGE_TOKEN_2']);
// По URL
$builder->image(url: 'https://example.com/image.png');
// Через локальный файл
$builder->image(store: public_path('image.png'));
```

## Видео

Видео можно добавить по токену или локальному файлу.

```php
// По токену
$builder->video(token: 'VIDEO_TOKEN');
// Через локальный файл
$builder->video(store: public_path('video.avi'));
```

## Аудио 

Аудио можно добавить по токену или локальному файлу.
```php
// По токену
$builder->audio(token: 'AUDIO_TOKEN');
// Через локальный файл
$builder->audio(store: public_path('audio.omg'));
```

## Файл

Файл можно добавить по токену или локальному файлу.
```php
// По токену
$builder->file(token: 'FILE_TOKEN');
// Через локальный файл
$builder->file(store: public_path('file.doc'));
```

## Стикер
```php
$builder->sticker(code: 'STICKER_CODE');
```

## Контакт
```php
$builder->contact(
    name: 'NAME',
    contact_id : 'CONTACT_ID', // optional
    vcf_info: 'VCF_INFO',      // optional
    vcf_phone: 'VCF_PHONE'     // optional
);
```

## Геолокация
```php
$builder->location('latitude', 'longitude');
```

## Share
Вложение типа `share` можно создать по URL или token.
```php
$builder->share(url: 'https://max.ru');
$builder->share(token: 'SHARE_TOKEN');
```

## Inline-клавиатура
Inline-клавиатура создаётся через метод `inlineKeyboard()`.

```php
$builder->inlineKeyboard($builder->button->callback());
```

Каждая одиночная кнопка помещается в отдельный ряд.

## Ряды кнопок

Чтобы разместить несколько кнопок в одном ряду, используйте метод `row()`.

php builder->inlineKeyboard(builder->row, $builder->button->link );


В этом примере кнопки `Да` и `Нет` будут в одном ряду, а кнопка `Открыть сайт` — в отдельном.

## ButtonBuilder

Кнопки доступны через свойство `$builder->button` внутри `AttachmentsBuilder`.


В этом примере кнопки `Да` и `Нет` будут в одном ряду, а кнопка `Открыть сайт` — в отдельном.

## ButtonBuilder

Кнопки доступны через свойство `$builder->button` внутри `AttachmentsBuilder`.

php $builder->button->callback;


## Callback-кнопка

php $builder->button->callback;

## Link-кнопка

php $builder->button->link

## Запрос геолокации

php $builder->button->requestGeoLocation;

Можно явно указать параметр `quick`:

php $builder->button->requestGeoLocation;

## Запрос контакта

php $builder->button->requestContact;

## Open App

php $builder->button->openApp;

Все параметры, кроме `text`, необязательные.

## Message-кнопка

php $builder->button->message;

## Clipboard-кнопка

php $builder->button->clipboard;

## Полный пример

php use VioletSun\MAX\Builder\AttachmentsBuilder; use VioletSun\MAX\Facades\MAX;
MAX::builder() ->chatId(1234567890) ->text('Сообщение с изображением и inline-клавиатурой') ->disableLinkPreview() ->attachments(function (AttachmentsBuilder builder) {builder->image(token: 'IMAGE_TOKEN');
$builder->inlineKeyboard(
$builder->row(
$builder->button->callback(
text: 'Подробнее',
payload: 'details',
),
$builder->button->link(
text: 'Сайт',
url: 'https://max.ru',
)
),
$builder->button->clipboard(
text: 'Скопировать промокод',
payload: 'PROMO2026',
)
);
})
->send();

## Пример редактирования сообщения

php MAX::builder() ->messageId('MESSAGE_ID') ->text('Сообщение было обновлено') ->edit();

## Пример удаления сообщения

php MAX::builder() ->messageId('MESSAGE_ID') ->delete();


## Примечания

- Для отправки сообщения через `send()` обязательно укажите `chatId()`.
- Для редактирования и удаления сообщения обязательно укажите `messageId()`.
- Вложения добавляются внутри callback-функции метода `attachments()`.
- Inline-клавиатура является вложением и добавляется через `AttachmentsBuilder`.
- Для загрузки локальных файлов используйте параметр `store`.
















```php
```

```php
```

```php
```

```php
```

```php
```

```php
```

```php
```

```php
```

```php
```

```php
```
