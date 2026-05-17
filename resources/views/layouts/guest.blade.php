<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dictionary' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
</head>
<body class="min-h-screen bg-white dark:bg-zinc-800">

    <div class="min-h-screen items-center justify-center">
        {{ $slot }}
    </div>

    @livewireScripts
    @fluxScripts
    <flux:toast/>
</body>
</html>
