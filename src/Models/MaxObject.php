<?php

namespace VioletSun\MAX\Models;

use Illuminate\Database\Eloquent\Model;
use VioletSun\MAX\Models\Max\Api;

class MaxObject extends Model
{
    public Api $api;

    public function __construct()
    {
        $this->api = new Api(getenv('MAXBOT_ACCESS_TOKEN'));
    }

    /*****************************************************
     * PRIVATE METHODS
     ****************************************************/




    /*****************************************************
     * PUBLIC METHODS
     ****************************************************/

    /**
     * Получаем данные
     * @example https://github.com/BushlanovDev/max-bot-api-client-php/blob/master/docs/README.md#Получение-обновлений-через-Long-Polling
     * @return void
     */
    public function getUpdates()
    {
        $resp = $this->api->getUpdates(
            limit: 50,  // Максимальное количество обновлений для получения [1-1000] (необязательно)
            // timeout: 10, // Таймаут в секундах [0-90] (необязательно)
        );

        foreach ($resp->updates as $up) {
            MaxUpdate::set($up);
        }
    }

    /*****************************************************
     * PUBLIC STATIC METHODS
     ****************************************************/

}
