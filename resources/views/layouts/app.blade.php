<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Football Tickets') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <!-- Navigation -->
            <nav class="bg-green-600 border-b border-green-500">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('home') }}" class="text-white font-bold text-xl">
                                    FootballTix
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <a href="{{ route('home') }}" 
                                   class="{{ request()->routeIs('home') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    Home
                                </a>
                                @auth
                                <a href="{{ route('my-tickets') }}" 
                                   class="{{ request()->routeIs('my-tickets') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                    My Tickets
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}"
                                       class="{{ request()->routeIs('admin.*') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-300' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                        Admin Panel
                                    </a>
                                @endif
                                @endauth
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            @auth
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="flex items-center text-sm font-medium text-white hover:text-green-100 focus:outline-none transition duration-150 ease-in-out">
                                            {{ Auth::user()->name }}

                                            <div class="ml-1">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')" class="text-gray-700 hover:bg-gray-100">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        <!-- Authentication -->
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault();
                                                            this.closest('form').submit();"
                                                    class="text-gray-700 hover:bg-gray-100">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                            @else
                            <div class="space-x-4">
                                <a href="{{ route('login') }}" 
                                   class="text-green-100 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                                    Log in
                                </a>
                                <a href="{{ route('register') }}" 
                                   class="bg-white text-green-600 hover:bg-green-50 px-3 py-2 rounded-md text-sm font-medium">
                                    Register
                                </a>
                            </div>
                            @endauth
                        </div>

                        <!-- Mobile menu button -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-green-100 hover:text-white hover:bg-green-700 focus:outline-none focus:bg-green-700 focus:text-white transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile menu -->
                <div class="sm:hidden" x-show="open">
                    <div class="pt-2 pb-3 space-y-1">
                        <a href="{{ route('home') }}" 
                           class="{{ request()->routeIs('home') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                            Home
                        </a>
                        @auth
                        <a href="{{ route('my-tickets') }}" 
                           class="{{ request()->routeIs('my-tickets') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                            My Tickets
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="{{ request()->routeIs('admin.*') ? 'bg-green-700 text-white' : 'text-green-100 hover:bg-green-700 hover:text-white' }} block px-3 py-2 rounded-md text-base font-medium">
                                Admin Panel
                            </a>
                        @endif
                        @endauth
                    </div>

                    @auth
                    <div class="pt-4 pb-3 border-t border-green-500">
                        <div class="flex items-center px-5">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full bg-green-700 flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                            </div>
                            <div class="ml-3">
                                <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                                <div class="text-sm font-medium text-green-100">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        <div class="mt-3 space-y-1 px-2">
                            <a href="{{ route('profile.edit') }}" 
                               class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-700">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-700">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="pt-4 pb-3 border-t border-green-500">
                        <div class="space-y-1 px-2">
                            <a href="{{ route('login') }}" 
                               class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-700">
                                Log in
                            </a>
                            <a href="{{ route('register') }}" 
                               class="block px-3 py-2 rounded-md text-base font-medium text-green-100 hover:text-white hover:bg-green-700">
                                Register
                            </a>
                        </div>
                    </div>
                    @endauth
                </div>
            </nav>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
