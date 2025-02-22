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
    <script src="//unpkg.com/alpinejs" defer></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation Bar -->
        <nav class="bg-black border-b border-green-500" x-data="{ open: false }">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-4">
                <div class="flex justify-between h-16">
                    <!-- Logo and Desktop Links -->
                    <div class="flex items-center">
                        <!-- Logo -->
                        <a href="{{ route('home') }}" class=" group flex items-center text-white font-bold text-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                        FootballTix
                        </a>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden sm:flex sm:ml-10 space-x-8">
                            <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('home') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-300' }}">
                                Home
                            </a>
                            @auth
                                <a href="{{ route('my-tickets') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('my-tickets') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-300' }}">
                                    My Tickets
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('admin.*') ? 'border-white text-white' : 'border-transparent text-green-100 hover:text-white hover:border-green-300' }}">
                                        Admin Panel
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div class="flex items-center">
                        @auth
                            <div x-data="{ dropdownOpen: false }" class="relative">
                                <!-- Trigger Button -->
                                <button 
                                    @click="dropdownOpen = !dropdownOpen" 
                                    @keydown.escape="dropdownOpen = false"
                                    class="flex items-center gap-2 px-4 py-2 bg-white text-black rounded-md hover:bg-green-300 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
                                >
                                    <span class="font-medium">Super Admin</span>
                                    <svg 
                                        xmlns="http://www.w3.org/2000/svg" 
                                        class="h-5 w-5 transition-transform duration-200"
                                        :class="{'rotate-180': dropdownOpen}"
                                        fill="none" 
                                        viewBox="0 0 24 24" 
                                        stroke="currentColor"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <!-- Dropdown Menu -->
                                <div 
                                    x-show="dropdownOpen"
                                    @click.away="dropdownOpen = false"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 z-50"
                                    style="display: none;"
                                >
                                    <div class="py-1">
                                        <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Profile Settings
                                        </a>

                                    </div>
                                    <div class="py-1">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="group flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                                                <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- Login and Register Links -->
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="text-white hover:text-green-100">Login</a>
                                <a href="{{ route('register') }}" class="text-white hover:text-green-100">Register</a>
                            </div>
                        @endauth
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white/80 hover:bg-green-500 focus:outline-none focus:bg-green-500 focus:text-white transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 text-white hover:text-white/80 text-base font-medium">
                        Home
                    </a>
                    @auth
                        <a href="{{ route('my-tickets') }}" class="block pl-3 pr-4 py-2 text-white hover:text-white/80 text-base font-medium">
                            My Tickets
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="block pl-3 pr-4 py-2 text-white hover:text-white/80 text-base font-medium">
                                Admin Panel
                            </a>
                        @endif
                    @endauth
                </div>

                @auth
                    <div class="pt-4 pb-1 border-t border-green-500">
                        <div class="px-4">
                            <div class="font-medium text-base text-white">{{ auth()->user()->name }}</div>
                            <div class="font-medium text-sm text-green-100">{{ auth()->user()->email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <a href="{{ route('profile.edit') }}" class="block pl-3 pr-4 py-2 text-white hover:text-white/80 text-base font-medium">
                                Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full pl-3 pr-4 py-2 text-white hover:text-white/80 text-base font-medium text-left">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="pt-4 pb-1 border-t border-green-500">
                        <div class="space-y-1 px-4">
                            <a href="{{ route('login') }}" class="block py-2 text-white hover:text-white/80 text-base font-medium">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="block py-2 text-white hover:text-white/80 text-base font-medium">
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