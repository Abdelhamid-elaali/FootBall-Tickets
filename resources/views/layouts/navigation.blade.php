<nav class="bg-green-600">
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
                    <a href="{{ route('home') }}" class="text-white hover:text-green-100 inline-flex items-center px-1 pt-1 text-sm font-medium">
                        Home
                    </a>
                    @auth
                        <a href="{{ route('my-tickets') }}" class="text-white hover:text-green-100 inline-flex items-center px-1 pt-1 text-sm font-medium">
                            My Tickets
                        </a>
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.panel') }}" class="text-white hover:text-green-100 inline-flex items-center px-1 pt-1 text-sm font-medium">
                                Admin Panel
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="flex items-center">
                @auth
                    <div class="relative ml-3">
                        <button type="button" onclick="toggleDropdown()" class="flex items-center rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2" id="user-menu-button">
                            <span class="sr-only">Open user menu</span>
                            <div class="flex items-center gap-2 rounded-full bg-gray-50 px-4 py-2">
                                <div class="h-8 w-8 rounded-full bg-gray-200">
                                    <svg class="h-8 w-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <span class="text-sm text-gray-900">{{ Auth::user()->name }}</span>
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="dropdown-menu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                            <div class="px-4 py-2 border-b">
                                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <svg class="mr-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                                Profile Settings
                            </a>
                            <a href="#" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                <svg class="mr-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                                Help Center
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <button type="submit" class="flex w-full items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <svg class="mr-3 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-white hover:text-green-100">Login</a>
                        <a href="{{ route('register') }}" class="text-white hover:text-green-100">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button onclick="toggleMobileMenu()" class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-green-700 focus:outline-none focus:bg-green-700 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path id="hamburger-icon" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden sm:hidden">
            <div class="space-y-1 pb-3 pt-2">
                <a href="{{ route('home') }}" class="text-white hover:text-green-100 block px-3 py-2 text-base font-medium">
                    Home
                </a>
                @auth
                    <a href="{{ route('my-tickets') }}" class="text-white hover:text-green-100 block px-3 py-2 text-base font-medium">
                        My Tickets
                    </a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.panel') }}" class="text-white hover:text-green-100 block px-3 py-2 text-base font-medium">
                            Admin Panel
                        </a>
                    @endif
                @endauth
            </div>

            @auth
                <div class="border-t border-green-700 pb-3 pt-4">
                    <div class="flex items-center px-3">
                        <div class="h-8 w-8 rounded-full bg-white/10">
                            <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-white/80">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('profile.edit') }}" class="text-white hover:text-green-100 block px-3 py-2 text-base font-medium">
                            Profile Settings
                        </a>
                        <a href="#" class="text-white hover:text-green-100 block px-3 py-2 text-base font-medium">
                            Help Center
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left text-white hover:text-green-100 block px-3 py-2 text-base font-medium">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('dropdown-menu');
        dropdown.classList.toggle('hidden');
    }

    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        
        mobileMenu.classList.toggle('hidden');
        hamburgerIcon.classList.toggle('hidden');
        closeIcon.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('dropdown-menu');
        const button = document.getElementById('user-menu-button');
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>
