<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- user info -->
    <meta name="user" content="{{ Auth::user() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.getElementById('opensidebar').addEventListener('click', () => {
                document.getElementById('sidebar').classList.toggle('active')
            })
            document.getElementById('sidebar').classList.remove('active')
        })
    </script>

</head>
<body>
    <div id="app">

        @include('navbar')
        <div class="wrapper">

            @include('sidebar')

            <div id="content">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>

        </div>   
  
    </div>

</body>
</html>
