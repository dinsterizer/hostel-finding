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

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link
        rel="icon"
        href="https://laravel.com/img/favicon/favicon-32x32.png"
    />
    <link
        rel="stylesheet"
        href="https://unpkg.com/easymde/dist/easymde.min.css"
    >
    <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
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
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    {!! GoogleReCaptchaV3::init() !!}
</head>

<body class="font-sans antialiased">

    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="mx-auto max-w-7xl py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    <div class="fixed bottom-3 right-3 z-50">
        <livewire:chat />
    </div>

    @stack('modals')
    @livewireScripts
    @livewire('notifications')
</body>

</html>
