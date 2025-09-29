<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'MyTalenta BCA' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-50 font-inter">
    <!-- Top Navigation Bar -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="px-4 sm:px-6">
            <div class="flex justify-between items-center h-16">
                <!-- Logo & Title -->
                <div class="flex items-center space-x-3">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-sm">MT</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">MyTalenta</h1>
                        <p class="text-xs text-gray-500 -mt-1">BCA Student Hub</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'text-blue-600' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('rumah-talenta') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-emerald-600 px-3 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('rumah-talenta*') ? 'text-emerald-700 bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 rounded-lg shadow-sm' : '' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('rumah-talenta*') ? 'text-emerald-600' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                        <span>Rumah Talenta</span>
                    </a>
                    <a href="{{ route('booking.room') }}"
                        class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors {{ request()->routeIs('booking*') ? 'text-blue-600' : '' }}">
                        Bookings
                    </a>
                    <a href="{{ route('shuttle.booking') }}"
                        class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-all duration-200 {{ request()->routeIs('shuttle*') ? 'text-blue-600 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg shadow-sm' : '' }}">
                        <svg class="w-4 h-4 {{ request()->routeIs('shuttle*') ? 'text-blue-600' : 'text-gray-500' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                        <span>Shuttle</span>
                    </a>
                </div>

                <!-- User Profile -->
                <div class="flex items-center space-x-3">
                    <!-- Notifications -->
                    <div class="relative">
                        <button id="notificationBtn"
                            class="relative p-2 text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5-5-5 5h5zm0 0v-2a6 6 0 00-6-6H9v2a6 6 0 006 6v2z" />
                            </svg>
                            <span
                                class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 transform translate-x-1 -translate-y-1"></span>
                        </button>

                        <!-- Notification Dropdown -->
                        <div id="notificationDropdown"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-900">Notifications</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"></div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900 font-medium">Welcome to MyTalenta!</p>
                                            <p class="text-xs text-gray-600 mt-1">Your BCA student dashboard is ready to
                                                use.</p>
                                            <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-green-500 rounded-full mt-2 flex-shrink-0"></div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900 font-medium">Booking Confirmed</p>
                                            <p class="text-xs text-gray-600 mt-1">Your discussion room booking has been
                                                approved.</p>
                                            <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-4 text-center">
                                    <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All
                                        Notifications</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Avatar -->
                    <div class="relative">
                        <button id="profileBtn"
                            class="flex items-center space-x-2 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                            <div
                                class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                <span class="text-white font-medium text-sm">{{ auth()->user()->initials() }}</span>
                            </div>
                            <div class="hidden sm:block text-left">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">
                                    {{ auth()->user()->role->display_name ?? 'Mahasiswa' }}
                                </p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Profile Dropdown -->
                        <div id="profileDropdown"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-lg border border-gray-200 z-50 hidden">
                            <div class="p-4 border-b border-gray-200">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                        <span class="text-white font-medium">{{ auth()->user()->initials() }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ auth()->user()->role->display_name ?? 'Mahasiswa' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Profile</span>
                                </a>
                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    </svg>
                                    <span>Settings</span>
                                </a>
                            </div>
                            <div class="border-t border-gray-200 py-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center space-x-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors w-full text-left">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Bottom Navigation (Mobile) -->
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 md:hidden z-40">
        <div class="grid grid-cols-5 h-16">
            <a href="{{ route('dashboard') }}"
                class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-400' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span class="text-xs font-medium">Home</span>
            </a>

            <a href="{{ route('booking.room') }}"
                class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('booking.room') ? 'text-blue-600' : 'text-gray-400' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                </svg>
                <span class="text-xs font-medium">Book</span>
            </a>

            <a href="{{ route('rumah-talenta') }}"
                class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('rumah-talenta') ? 'text-blue-600' : 'text-gray-400' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                <span class="text-xs font-medium">Dorm</span>
            </a>

            <a href="{{ route('shuttle.booking') }}"
                class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('shuttle.booking') ? 'text-blue-600' : 'text-gray-400' }} transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                <span class="text-xs font-medium">Shuttle</span>
            </a>

            <button onclick="toggleProfileMenu()"
                class="flex flex-col items-center justify-center space-y-1 text-gray-400 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-xs font-medium">Profile</span>
            </button>
        </div>
    </nav>

    <!-- Profile Menu Overlay (Mobile) -->
    <div id="profileMenu" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
        <div class="fixed bottom-0 left-0 right-0 bg-white rounded-t-xl p-6 transform translate-y-full transition-transform duration-300"
            id="profilePanel">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Profile Menu</h3>
                <button onclick="toggleProfileMenu()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-4">
                <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-medium">{{ auth()->user()->initials() }}</span>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
                        <p class="text-xs text-blue-600 font-medium">
                            {{ auth()->user()->role->display_name ?? 'Mahasiswa' }}</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <a href="{{ route('settings.profile') }}"
                        class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-gray-900">Settings</span>
                    </a>

                    @if (auth()->user()->role && in_array(auth()->user()->role->name, ['core_team', 'admin_core_team']))
                        <a href="#"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            <span class="text-gray-900">Core Team Panel</span>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full ml-auto">Admin</span>
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center space-x-3 p-3 rounded-lg hover:bg-red-50 transition-colors w-full text-left">
                            <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="text-red-600">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Notification dropdown functionality
        document.getElementById('notificationBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notificationDropdown');
            const profileDropdown = document.getElementById('profileDropdown');

            // Close profile dropdown if open
            profileDropdown.classList.add('hidden');

            // Toggle notification dropdown
            dropdown.classList.toggle('hidden');
        });

        // Profile dropdown functionality
        document.getElementById('profileBtn').addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('profileDropdown');
            const notificationDropdown = document.getElementById('notificationDropdown');

            // Close notification dropdown if open
            notificationDropdown.classList.add('hidden');

            // Toggle profile dropdown
            dropdown.classList.toggle('hidden');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            const notificationDropdown = document.getElementById('notificationDropdown');
            const profileDropdown = document.getElementById('profileDropdown');
            const notificationBtn = document.getElementById('notificationBtn');
            const profileBtn = document.getElementById('profileBtn');

            if (!notificationBtn.contains(e.target) && !notificationDropdown.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }

            if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.add('hidden');
            }
        });

        function toggleProfileMenu() {
            const menu = document.getElementById('profileMenu');
            const panel = document.getElementById('profilePanel');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                setTimeout(() => {
                    panel.classList.remove('translate-y-full');
                }, 10);
            } else {
                panel.classList.add('translate-y-full');
                setTimeout(() => {
                    menu.classList.add('hidden');
                }, 300);
            }
        }

        // Close menu when clicking outside
        document.getElementById('profileMenu').addEventListener('click', function(e) {
            if (e.target === this) {
                toggleProfileMenu();
            }
        });
    </script>

    @livewireScripts
</body>

</html>
