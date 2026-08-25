<?php

declare(strict_types=1);

namespace VioletSun\MAX\Methods;

use VioletSun\MAX\Client;
use VioletSun\MAX\Enums\UpdateTypeEnum;
use VioletSun\MAX\Objects\AbstractObject;
use VioletSun\MAX\Objects\Me;
use VioletSun\MAX\Objects\Updates;

/**
 * Class Get.
 *
 * @mixin Client
 */
trait Commands
{
    /**
     * The method adds, modifies, or deletes bot commands that are displayed to the user as prompts when they enter “/”.
     *
     * @param $commands
     * @return AbstractObject
     *
     * <code>
     *  $commands = [
     *    [
     *        "name" => "string",
     *        "description" => "string"
     *    ]
     *  ];
     * </code>
     *
     * @link https://dev.max.ru/docs-api/methods/PATCH/me/commands
     */
    public function commands($commands): AbstractObject
    {
        return AbstractObject::fromArray($this->client->patch("me/commands", ['commands' => $commands]));
    }

    /**
     * To delete commands
     *
     * @return AbstractObject
     *
     * @link https://dev.max.ru/docs-api/methods/PATCH/me/commands
     */
    public function clearCommands(): AbstractObject
    {
        return AbstractObject::fromArray($this->client->patch("me/commands", ['commands' => []]));
    }
}
