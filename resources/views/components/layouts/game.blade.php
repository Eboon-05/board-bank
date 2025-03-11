<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? 'Game - Board Bank' }}</title>

        <script>
            window.game = @json($game);
        </script>

        <!-- Scripts -->
        @vite([
            'resources/css/fonts.css',
            'resources/css/app.css',
            'resources/js/game.js'
        ])
    </head>
    <body>
        {{ $slot }}
    </body>
</html>
