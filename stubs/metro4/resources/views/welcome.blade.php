<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="metro4:init:mode" content="immediate">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="h-vh-100">
<div class="pos-fixed fixed-top app-bar-wrapper z-top">
    <header class="container pos-relative app-bar" data-role="appbar" data-expand-point="md">
        <a href="#" class="brand no-hover fg-cyan">Soyosake</a>

        <div class="app-bar-container">
            <a href="#" class="app-bar-item">Info</a>

        </div>
        @if (Route::has('login'))
            <div class="app-bar-container ml-auto">
                @auth
                    <a href="{{ url('/home') }}" class="app-bar-item text-center">Home</a>
                @else
                    <a href="{{ route('login') }}" class="app-bar-item text-center fg-darkCobalt">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="app-bar-item text-center fg-darkCobalt">Register</a>
                    @endif
                @endauth
            </div>
        @endif

    </header>
</div>
<div class="pt-16" id="image">
    <div class="container">
        <div class="img-container">
            <img src="{{ asset('images/socialcard.png') }}">
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
