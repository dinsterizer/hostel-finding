<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <x-ga4 />

    <meta charset="utf-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >
    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    @env('local')
    <meta
        name="referrer"
        content="no-referrer"
    />
    @endenv

    {{ $head ?? null }}
    <link
        rel="icon"
        href="https://laravel.com/img/favicon/favicon-32x32.png"
    />

    <!-- Fonts -->
    <link
        rel="stylesheet"
        href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap"
    >

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Scripts -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/css/places-autocomplete-dropdown.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    @stack('styles')

    {!! GoogleReCaptchaV3::init() !!}
</head>

<body>

    <div {{ $attributes->class('flex-1 font-sans text-gray-900 antialiased') }}>
        {{ $slot }}
    </div>

    <div class="fixed bottom-3 right-3 z-50">
        <livewire:chat />
    </div>

    @livewireScripts
    @stack('scripts')
    @livewire('notifications')
</body>

</html>
