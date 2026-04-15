<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Event Booking System — Laravel Developer Assessment">

        @php
            $appName = config('app.name', 'Event Booking System');
            if ($appName === 'Laravel') {
                $appName = 'Event Booking System';
            }
        @endphp
        <title>Home | {{ $appName }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-950 text-white">
        <div class="min-h-screen flex flex-col items-center justify-center px-6 relative overflow-hidden">

            {{-- Decorative background gradient --}}
            <div class="absolute inset-0 -z-10">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full bg-indigo-500/10 blur-3xl"></div>
                <div class="absolute top-1/3 left-1/4 w-[300px] h-[300px] rounded-full bg-purple-500/10 blur-3xl"></div>
                <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] rounded-full bg-blue-500/10 blur-3xl"></div>
            </div>

            {{-- Main content --}}
            <div class="text-center max-w-lg">
                {{-- Icon / Logo mark --}}
                <div class="mx-auto mb-8 flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-500/20 ring-1 ring-indigo-500/30">
                    <svg class="h-8 w-8 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                </div>

                <h1 class="text-4xl sm:text-5xl font-bold tracking-tight text-white">
                    Event Booking System
                </h1>

                {{-- Action buttons --}}
                <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           id="btn-dashboard"
                           class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-950">
                            Dashboard
                            <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    @else
                        <a href="{{ route('events.index') }}"
                           id="btn-browse-events"
                           class="inline-flex items-center justify-center rounded-lg border border-white/25 bg-white/5 px-8 py-3 text-sm font-semibold text-white transition hover:bg-white/15 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-950">
                            Browse as Guest
                        </a>

                        <a href="{{ route('login') }}"
                           id="btn-login"
                           class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-8 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-500/25 transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-950">
                            Login
                        </a>

                        <a href="{{ route('register') }}"
                           id="btn-register"
                           class="inline-flex items-center justify-center rounded-lg bg-white/10 px-8 py-3 text-sm font-semibold text-white ring-1 ring-white/20 transition hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-950">
                            Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
