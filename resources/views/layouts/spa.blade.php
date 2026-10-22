<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#18191c">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon-192.png">
    <link rel="apple-touch-icon" href="/favicon-192.png">
</head>
<body>
    @php
        $appData = [
            'notes' => $notes ?? [],
            'user' => Auth::user(),
            'appname' => config('app.name', 'Laravel'),
        ];
    @endphp
    <script id="app-data" type="application/json">@json($appData)</script>
    <div id="app"></div>
</body>
</html>
