<?php

declare(strict_types=1);

namespace VioletSun\MAX\Enums;

enum MessageFormatEnum: string
{
    /**
     * @link https://dev.max.ru/docs-api#Markdown
     */
    case Markdown = 'markdown';

    /**
     * https://dev.max.ru/docs-api#HTML
     */
    case Html = 'html';
}
