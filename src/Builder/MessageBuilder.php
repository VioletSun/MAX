<?php

namespace VioletSun\MAX\Builder;

use VioletSun\MAX\Enums\MessageFormatEnum;
use VioletSun\MAX\Exceptions\MessageException;
use VioletSun\MAX\Facades\MAX;
use VioletSun\MAX\Objects\AbstractObject;

class MessageBuilder
{
    protected ?int $chat_id;
    protected ?string $message_id;
    protected bool $disable_link_preview = false;
    protected string $text = '';
    protected array $attachments = [];
    protected mixed $link = null;
    protected bool $notify = true;
    protected MessageFormatEnum $format;

    public function __construct(array $array = [])
    {
        $this->chat_id = $array["chat_id"] ?? null;
        $this->message_id = $array["message_id"] ?? null;
        $this->disable_link_preview = $array["disable_link_preview"] ?? false;
        $this->text = $array["text"] ?? '';
        $this->notify = $array["notify"] ?? true;
        $this->format = $array["format"] ?? MessageFormatEnum::Html;
        $this->attachments = $array["attachments"] ?? [];
    }

    /**
     * @param int $chat_id
     * @return $this
     */
    public function chatId(int $chat_id): MessageBuilder
    {
        $this->chat_id = $chat_id;
        return $this;
    }

    /**
     * @param string $message_id
     * @return $this
     */
    public function messageId(string $message_id): MessageBuilder
    {
        $this->message_id = $message_id;
        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function text(string $text): MessageBuilder
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return $this
     */
    public function disableLinkPreview(): MessageBuilder
    {
        $this->disable_link_preview = true;
        return $this;
    }

    /**
     * @param callable $callback
     * <code>
     * ->attachments(function (AttachmentsBuilder $builder) {
     *      $builder->image(
     *          token: "TOKEN_IMAGE"
     *      );
     *      $builder->inlineKeyboard(
     *          $builder->row(
     *              $builder->button->link(
     *                  text: "Ссылка 1",
     *                  url: "https://max.ru",
     *              ),
     *              $builder->button->callback(
     *                  text: "Кнопка 1",
     *                  payload: "btn-1",
     *              )
     *          ),
     *          $builder->button->callback(
     *              text: "Кнопка 2",
     *              payload: "btn-2",
     *          )
     *      );
     * })
     * </code>
     * @return $this
     */
    public function attachments(callable $callback): self
    {
        $builder = new AttachmentsBuilder();
        $callback($builder);
        $this->attachments = $builder->getAttachments();
        return $this;
    }

    /**
     * @return array
     */
    private function handleData(): array
    {
        $data = [
            'disable_link_preview' => $this->disable_link_preview,
            'notify' => $this->notify,
            'format' => $this->format,
        ];
        if ($this->text) {
            $data['text'] = $this->text;
        }
        if ($this->attachments) {
            $data['attachments'] = $this->attachments;
        }
        return $data;
    }

    /**
     * @return $this
     */
    public function dump(): static
    {
        dump($this);
        return $this;
    }

    /**
     * @return AbstractObject
     * @throws MessageException
     */
    public function send(): AbstractObject
    {
        if (empty($this->chat_id)) {
            throw MessageException::required('chat_id');
        }
        return MAX::sendMessage($this->chat_id, $this->handleData());
    }

    /**
     * @throws MessageException
     */
    public function edit(): array
    {
        if (empty($this->message_id)) {
            throw MessageException::required('message_id');
        }
        return MAX::editMessage($this->message_id, $this->handleData());
    }

    /**
     * @throws MessageException
     */
    public function delete(): array
    {
        if (empty($this->message_id)) {
            throw MessageException::required('message_id');
        }
        return MAX::deleteMessage($this->message_id);
    }
}
