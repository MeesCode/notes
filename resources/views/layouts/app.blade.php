<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#18191c">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css'])

    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" type="image/png" sizes="192x192" href="/favicon-192.png">
    <link rel="apple-touch-icon" href="/favicon-192.png">
</head>
<body>
    <main class="auth">
        <div class="card">
            <a class="auth-brand" href="{{ url('/') }}">
                <img src="/note.svg" alt="">
                {{ config('app.name', 'Laravel') }}
            </a>

            @yield('content')
        </div>
    </main>
</body>
</html>
