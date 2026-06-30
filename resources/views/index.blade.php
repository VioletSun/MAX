<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Obligatorily for MAX-->
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'self' https://trusted-platform.com;">
    <meta http-equiv="X-Frame-Options" content="ALLOW-FROM https://web.max.ru">

    <title>{{ config('app.name', '') }}</title>

    <!-- Style -->
    <link href="{{ asset('vendor/violetsun/max/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
<div class="vh-100 d-flex justify-content-center align-items-center">
    <h1 class="text-center">Hello <span id="name"></span></h1>
</div>
</body>

<!-- Obligatorily for MAX-->
<script src="https://st.max.ru/js/max-web-app.js"></script>

<script src="{{ asset('vendor/violetsun/max/js/popper.min.js') }}"></script>
<script src="{{ asset('vendor/violetsun/max/js/bootstrap.bundle.min.js') }}" ></script>
<script src="{{ asset('vendor/violetsun/max/js/jquery-3.7.0.min.js') }}"></script>

<script src="{{ asset('vendor/violetsun/max/js/app.js') }}"></script>
</html>
