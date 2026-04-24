<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head><body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100" x-data="{ sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true', mobileMenuOpen: false }" x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value))">
        <div class="flex h-screen bg-gray-100 overflow-hidden">
            <!-- Sidebar -->
            <div class="hidden md:flex md:flex-shrink-0 transition-all duration-300 ease-in-out" :class="sidebarCollapsed ? 'w-20' : 'w-64'">
                <div class="flex flex-col w-full h-full">
                    <div class="flex flex-col flex-grow py-4 overflow-y-auto bg-black border-r border-green-900/20 transition-all duration-300 ease-in-out">
                        <!-- Sidebar Logo/Toggle -->
                        <div class="flex items-center justify-between px-4 pb-6 border-b border-green-900/50 mb-4">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center text-lg font-bold tracking-tight text-white focus:outline-none" x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-7 h-7 mr-2 text-green-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                                </svg>
                                <span>FootballTix</span>
                            </a>
                            <button @click="sidebarCollapsed = !sidebarCollapsed" class="p-2 rounded-xl bg-green-900/30 text-green-400 hover:bg-green-700 hover:text-white transition-all focus:outline-none" :class="sidebarCollapsed ? 'mx-auto' : ''">
                                <svg class="w-5 h-5 transition-transform duration-500" :class="sidebarCollapsed ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </button>
                        </div>

                        <!-- Navigation -->
                        <div class="px-3 space-y-2">
                            <a href="{{ route('home') }}" class="group flex items-center px-3 py-3 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('home') ? 'text-white bg-green-700 shadow-lg shadow-green-900/20' : 'text-green-100 hover:bg-green-900/50 hover:text-white' }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                                <svg class="w-6 h-6 transition-transform group-hover:scale-110" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">Home</span>
                            </a>

                            <nav class="space-y-2 pt-4 border-t border-green-900/30">
                                <a href="{{ route('admin.dashboard') }}" class="group flex items-center px-3 py-3 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('admin.dashboard') ? 'text-white bg-green-700 shadow-lg shadow-green-900/20' : 'text-green-100 hover:bg-green-900/50 hover:text-white' }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">Dashboard</span>
                                </a>

                                <a href="{{ route('admin.matches.index') }}" class="group flex items-center px-3 py-3 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('admin.matches.*') ? 'text-white bg-green-700 shadow-lg shadow-green-900/20' : 'text-green-100 hover:bg-green-900/50 hover:text-white' }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">Matches</span>
                                </a>

                                <a href="{{ route('admin.bookings.index') }}" class="group flex items-center px-3 py-3 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('admin.bookings.*') ? 'text-white bg-green-700 shadow-lg shadow-green-900/20' : 'text-green-100 hover:bg-green-900/50 hover:text-white' }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">Bookings</span>
                                </a>

                                <a href="{{ route('admin.users.index') }}" class="group flex items-center px-3 py-3 text-sm font-medium transition-all duration-200 rounded-xl {{ request()->routeIs('admin.users.*') ? 'text-white bg-green-700 shadow-lg shadow-green-900/20' : 'text-green-100 hover:bg-green-900/50 hover:text-white' }}" :class="sidebarCollapsed ? 'justify-center' : ''">
                                    <svg class="w-6 h-6 transition-transform group-hover:scale-110" :class="sidebarCollapsed ? '' : 'mr-3'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <span x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">Users</span>
                                </a>
                            </nav>
                        </div>

                        <!-- User Profile Area -->
                        <div class="mt-auto px-3 pb-6">
                            <div class="flex flex-col p-2.5 rounded-[2rem] bg-green-950/40 border border-green-900/50 shadow-inner transition-all duration-300" :class="sidebarCollapsed ? 'items-center py-4' : 'p-3'">
                                <div class="flex items-center" :class="sidebarCollapsed ? 'flex-col space-y-3' : ''">
                                    <div class="flex-shrink-0 relative group">
                                        <img class="w-9 h-9 rounded-full border-2 border-green-500/30 transition-all duration-300 group-hover:border-green-400 shadow-lg object-cover" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=059669&color=fff&rounded=true" alt="{{ auth()->user()->name }}">
                                        <div class="absolute -top-0.5 -right-0.5 w-3 h-3 bg-green-500 border-2 border-black rounded-full"></div>
                                    </div>
                                    <div class="ml-3 transition-all duration-300 overflow-hidden" x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                                        <p class="text-sm font-bold text-white truncate w-32">{{ auth()->user()->name }}</p>
                                        <p class="text-[10px] text-green-500 font-bold uppercase tracking-wider">{{ auth()->user()->role }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-4 w-full" x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="group flex items-center justify-center w-full px-4 py-2.5 text-xs font-bold text-green-100 hover:text-white bg-green-900/40 hover:bg-green-700 rounded-full transition-all border border-green-800/30">
                                            <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="mt-2" x-show="sidebarCollapsed">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="p-2.5 text-green-400 hover:text-white hover:bg-green-700 rounded-full transition-all border border-green-800/30" title="Logout">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div class="md:hidden fixed inset-0 z-40 flex" x-show="mobileMenuOpen" style="display: none;">
                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm" @click="mobileMenuOpen = false"></div>

                <!-- Menu -->
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-black">
                    <div class="absolute top-0 right-0 -mr-12 pt-2">
                        <button class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" @click="mobileMenuOpen = false">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Sidebar content clone for mobile could go here -->
                </div>
            </div>

            <!-- Main content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <main class="flex-1 relative overflow-y-auto focus:outline-none bg-gray-50/50">
                    @if (isset($header))
                        <header class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-10">
                            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                                <div class="flex justify-between items-center">
                                    {{ $header }}
                                    <x-user-dropdown />
                                </div>
                            </div>
                        </header>
                    @endif

                    <div class="py-6 px-4 sm:px-6 lg:px-8">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Mobile menu button -->
    <div class="md:hidden fixed bottom-6 right-6 z-50">
        <button type="button" @click="mobileMenuOpen = true" class="bg-green-600 p-4 rounded-2xl text-white shadow-2xl shadow-green-600/40 hover:bg-green-500 hover:scale-105 active:scale-95 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>
</body>
</html>
