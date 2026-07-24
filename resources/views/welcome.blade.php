<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Staff Management System') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased selection:bg-[#ebae34] selection:text-black">
        <!-- Full-Screen Background Container -->
        <!-- REPLACE 'your-image-url.jpg' with your actual background image asset e.g. {{ asset('images/bg.jpg') }} -->
        <div class="relative min-h-screen flex flex-col justify-between items-center bg-cover bg-center bg-no-repeat" style="background-image: url('your-image-url.jpg');">
            
            <!-- Background Overlay -->
            <div class="absolute inset-0 bg-slate-950/40 backdrop-blur-xs"></div>

            <!-- Header / Logo -->
            <header class="relative z-10 pt-8">
                <div class="flex items-center gap-3 bg-[#ebae34] px-6 py-2.5 rounded-full shadow-xl">
                    <div class="p-1.5 bg-black rounded-full">
                        <svg class="w-5 h-5 text-[#ebae34]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-xl font-black tracking-wider text-black uppercase">StaffMS</span>
                </div>
            </header>

            <!-- Main Hero Content -->
            <main class="relative z-10 w-full max-w-md px-6 py-12">
                <!-- Card Container with Bright Glassmorphism -->
                <div class="bg-white/85 backdrop-blur-md border border-white/60 rounded-3xl p-8 shadow-2xl text-center">
                    
                    <!-- Title & Tagline -->
                    <h1 class="text-3xl sm:text-4xl font-black text-black tracking-tight leading-tight">
                        Staff Management System
                    </h1>
                    
                    <p class="mt-4 text-sm sm:text-base text-black font-semibold leading-relaxed">
                        Streamline your organization’s staff records, station assignments, and monthly reporting in one place.
                    </p>

                    <!-- Compact Action Buttons (Normal Size) -->
                    <div class="mt-8 flex flex-row items-center justify-center gap-3">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" 
                                   style="background-color: #ebae34;"
                                   class="px-5 py-2 rounded-full font-bold text-sm text-black hover:brightness-105 shadow-md shadow-[#ebae34]/30 transition duration-200 active:scale-[0.98] inline-flex items-center">
                                    Go to Dashboard
                                    <svg class="ml-1.5 w-4 h-4 text-black stroke-[2.5]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}" 
                                   style="background-color: #ebae34;"
                                   class="px-5 py-2 rounded-full font-bold text-sm text-black hover:brightness-105 shadow-md shadow-[#ebae34]/30 transition duration-200 active:scale-[0.98] text-center min-w-[90px]">
                                    Log In
                                </a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" 
                                       style="background-color: #ebae34;"
                                       class="px-5 py-2 rounded-full font-bold text-sm text-black hover:brightness-105 shadow-md shadow-[#ebae34]/30 transition duration-200 active:scale-[0.98] text-center min-w-[90px]">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="relative z-10 pb-6 text-center">
                <p class="text-xs font-bold text-black drop-shadow-sm">
                    &copy; {{ date('Y') }} Staff Management System. All rights reserved.
                </p>
            </footer>

        </div>
    </body>
</html>