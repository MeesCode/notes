<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <meta name="mobile-web-app-capable" content="yes">
    <link rel="shortcut icon" type="image/png" href="favicon-192.png">
    <link rel="shortcut icon" sizes="192x192" href="favicon-192.png">
    <link rel="apple-touch-icon" href="favicon-192.png">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <ul class="navbar-nav ml-auto">
                <li>
                    <a class="nav-link" href="{{ route('login') }}">
                        login
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="{{ route('register') }}">
                        register
                    </a>
                </li>
            </ul>
        </nav>

        <div class="wrapper">
            <div id="content">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>   
    </div>
</body>
</html>
