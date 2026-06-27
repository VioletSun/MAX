<?php

return [
    /*-------------------------------------------------------------------------|
    | Base API Url [Optional]                                                  |
    | Default: https://platform-api2.max.ru                                     |
    |-------------------------------------------------------------------------*/
    'base_uri' => env('MAX_BASE_URI', 'https://platform-api2.max.ru'),

    /*-------------------------------------------------------------------------|
    | Your MAX API key                                                         |
    |-------------------------------------------------------------------------*/
    'api_key' => env('MAX_API_KEY'),

    /*-------------------------------------------------------------------------|
    | Timeout in seconds for long polling                                      |
    | Default: 10                                                              |
    |-------------------------------------------------------------------------*/
    'timeout' => env('MAX_TIMEOUT', 10),

    /*-------------------------------------------------------------------------|
    | Save data to database                                                    |
    | Default: false                                                           |
    | Need: Package vendor publish and migrations                              |
    |-------------------------------------------------------------------------*/
    'save_data' => env('MAX_SAVE_DATA', false),

    /*-------------------------------------------------------------------------|
    | Run queue class Update                                                   |
    | Default: false                                                           |
    | Need: Package vendor publish and migrations                              |
    |-------------------------------------------------------------------------*/
    'enqueue' => env('MAX_ENQUEUE', false),

    /*-------------------------------------------------------------------------|
    | Webhook update types                                                     |
    | Default: null - all                                                      |
    | Example: bot_started,message_created                                     |
    |-------------------------------------------------------------------------*/
    'webhook_update_types' => env('MAX_WEBHOOK_UPDATE_TYPES'),
];
