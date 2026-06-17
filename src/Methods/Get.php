<?php

namespace VioletSun\MAX\Methods;

use VioletSun\MAX\Client;
use VioletSun\MAX\Enums\UpdateTypeEnum;
use VioletSun\MAX\Objects\Updates;

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
        return $this->client->get("me");
    }

    /**
     * Receiving event updates via Long Polling.
     *
     * @param int|null $limit
     * @param int|null $timeout
     * @param int|null $marker
     * @param UpdateTypeEnum|null $types
     *
     * @return Updates
     *
     * @link https://dev.max.ru/docs-api/methods/GET/updates
     */
    public function updates(?int $limit = 100, ?int $timeout = 10, ?int $marker = null, ?UpdateTypeEnum $types = null): Updates
    {
        $args = compact('limit', 'timeout');
        if (!is_null($marker)) {
            $args['marker'] = $marker;
        }
        if (!empty($types)) {
            $args['types'] = $types->value;
        }
        $updates = Updates::fromArray($this->client->get("updates", $args));
        $updates->handleData();
        return $updates;
    }
}
