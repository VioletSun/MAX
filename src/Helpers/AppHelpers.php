<?php

declare(strict_types=1);

if (!function_exists('max_make_app_token')) {
    function max_make_app_token(): string
    {
        return "1234567890";
    }
}

if (!function_exists('max_check_app_token')) {
    function max_check_app_token(string $token): bool
    {
        return $token == "1234567890";
    }
}
