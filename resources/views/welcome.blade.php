<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Staff Management System') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col">
            <header class="site-header">
                <div class="page-shell flex items-center justify-between py-5">
                    <a href="/" class="brand-lockup"><span class="brand-mark">SM</span><span>StaffMS</span></a>
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="ui-button px-4 py-2 text-sm">Dashboard</a>
                        @else
                            <div class="flex gap-2">
                                <a href="{{ route('login') }}" class="ui-button px-4 py-2 text-sm">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="ui-button px-4 py-2 text-sm">Register</a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </div>
            </header>
            <main class="page-shell flex flex-1 items-center">
                <div class="flex w-full flex-col items-center justify-center text-center">
                    <h1 class="text-4xl font-extrabold text-black sm:text-6xl">Staff Management System</h1>
                </div>
            </main>
        </div>
    </body>
</html>
