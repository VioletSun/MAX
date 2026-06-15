<?php

namespace VioletSun\MAX\Methods;

use VioletSun\MAX\Client;

/**
 * Class Get.
 *
 * @mixin Client
 */
trait Get
{
    /**
     * A simple method for testing your bot's auth token.
     * Returns basic information about the bot.
     *
     * @link https://dev.max.ru/docs-api/methods/GET/me
     */
    public function me(): array
    {
        return $this->get("me");
    }
}
