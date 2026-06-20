<?php

declare(strict_types=1);

namespace VioletSun\MAX\Objects\Message;

use VioletSun\MAX\Objects\Attachment\Attachment;
use VioletSun\MAX\Support\BaseObject;

final class Body extends BaseObject
{
    public static function fromArray(array $data): static
    {
        $attachments = [];
        foreach ($data['attachments'] ?? [] as $attachment) {
            $attachments[] = Attachment::fromArray($attachment);
        }
        $markups = [];
        foreach (($data['markup'] ?? []) as $m) {
            $markups[] = Markup::fromArray($m);
        }

        return new self([
            'mid' => $data['mid'] ?? null,
            'seq' => $data['seq'] ?? null, // может быть big-int, пусть будет mixed
            'text' => $data['text'] ?? null,
            'markup' => $markups,
            'attachments' => $attachments,
        ]);
    }
}
