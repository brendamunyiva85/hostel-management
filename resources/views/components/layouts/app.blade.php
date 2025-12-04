<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div class="flex">
                <nav class="w-64 bg-white border-r min-h-screen flex flex-col">
                    <div class="p-6">
                        <a href="{{ url('/') }}" class="flex items-center space-x-2">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a1 1 0 001 1h16a1 1 0 001-1V7" />
                            </svg>
                            <span class="font-bold text-lg">{{ config('app.name', 'Laravel') }}</span>
                        </a>
                    </div>

                    <div class="px-4">
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('dashboard') ?? url('/dashboard') }}" class="block px-4 py-2 rounded hover:bg-gray-100 {{ request()->is('dashboard*') ? 'bg-gray-100 font-medium' : '' }}">
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('allocations.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100 {{ request()->is('allocations*') ? 'bg-gray-100 font-medium' : '' }}">
                                    Allocations
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('students.index') }}" class="block px-4 py-2 rounded hover:bg-gray-100 {{ request()->is('students*') ? 'bg-gray-100 font-medium' : '' }}">
                                    Students
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="mt-auto px-4 py-6">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 rounded hover:bg-gray-100 text-red-600">
                                Logout
                            </button>
                        </form>
                    </div>
                </nav>

                <div class="flex-1">
                    @isset($header)
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <main>
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>