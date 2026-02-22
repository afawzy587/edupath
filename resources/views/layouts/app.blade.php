<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ str_replace('_', '-', app()->getLocale()) == 'ar' ? 'rtl' : 'ltr' }}" >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>{{ $title ?? config('app.name') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body>
    @if (session()->has('success'))
        <div class="flash-success fixed left-4 right-4 top-4 z-50 max-w-sm px-4 sm:left-auto sm:right-4">
            <div class="rounded-lg border border-teal-200 bg-teal-50 px-4 py-3 text-teal-800 shadow-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

        {{ $slot }}

        @livewireScripts
    </body>
</html>
