<?php

return [
    'base_uri' => env('MAX_BASE_URI', 'https://platform-api.max.ru'),
    'api_key' => env('MAX_API_KEY', ''),
    'timeout' => env('MAX_TIMEOUT', 10),
    'headers' => [
        'Accept' => 'application/json',
    ],
];
