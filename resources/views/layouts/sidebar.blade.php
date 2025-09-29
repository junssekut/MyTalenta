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
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gradient-to-br from-blue-50 via-indigo-100 to-blue-200 shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 backdrop-blur-md border-r border-white/20">
            <div class="flex flex-col h-full">
                <!-- Logo & Brand -->
                <div class="flex items-center justify-between h-16 px-6 border-b border-white/30">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-blue-600 to-blue-700 rounded-lg flex items-center justify-center shadow-lg">
                            <span class="text-white font-bold text-sm">MT</span>
                        </div>
                        <div>
                            <h1 class="text-lg font-semibold text-gray-900">MyTalenta</h1>
                            <p class="text-xs text-blue-700 -mt-1 font-medium">Management Panel</p>
                        </div>
                    </div>
                    <button onclick="toggleSidebar()"
                        class="lg:hidden text-gray-600 hover:text-gray-800 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-white/90 text-blue-700 shadow-lg border border-blue-200' : 'text-gray-700 hover:bg-white/80 hover:shadow-md' }} transition-all duration-300 backdrop-blur-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span class="font-medium">Dashboard</span>
                    </a>

                    <!-- Dormitory Section -->
                    @if (auth()->user()->role &&
                            in_array(auth()->user()->role->name, ['core_team', 'admin_core_team', 'building_management']))
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold text-blue-700 uppercase tracking-wider mb-3">Rumah Talenta
                            </h3>
                            <div class="space-y-1">
                                <a href="{{ route('rumah-talenta') }}"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('rumah-talenta') ? 'bg-white/90 text-blue-700 shadow-lg border border-blue-200' : 'text-gray-700 hover:bg-white/80 hover:shadow-md' }} transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <span>Overview</span>
                                </a>

                                <a href="{{ route('booking.dormitory-room') }}"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-white/80 hover:shadow-md transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                                    </svg>
                                    <span>Book Room</span>
                                </a>

                                <a href="{{ route('booking.facility') }}"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-white/80 hover:shadow-md transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    <span>Facility Bookings</span>
                                    <span
                                        class="ml-auto bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-medium">8</span>
                                </a>

                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-white/80 hover:shadow-md transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Maintenance</span>
                                    <span
                                        class="ml-auto bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-medium">3</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Transportation Section -->
                    @if (auth()->user()->role && in_array(auth()->user()->role->name, ['pic_shuttle', 'core_team', 'admin_core_team']))
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold text-blue-700 uppercase tracking-wider mb-3">
                                Transportation</h3>
                            <div class="space-y-1">
                                <a href="{{ route('shuttle.booking') }}"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ request()->routeIs('shuttle.booking') ? 'bg-white/90 text-blue-700 shadow-lg border border-blue-200' : 'text-gray-700 hover:bg-white/80 hover:shadow-md' }} transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                    </svg>
                                    <span>Shuttle Management</span>
                                </a>

                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-white/80 hover:shadow-md transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span>Routes & Schedules</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- System Administration -->
                    @if (auth()->user()->role && in_array(auth()->user()->role->name, ['admin_core_team']))
                        <div class="pt-6">
                            <h3 class="px-4 text-xs font-bold text-blue-700 uppercase tracking-wider mb-3">
                                Administration</h3>
                            <div class="space-y-1">
                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-white/80 hover:shadow-md transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                    </svg>
                                    <span>User Management</span>
                                </a>

                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-white/80 hover:shadow-md transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>System Settings</span>
                                </a>

                                <a href="#"
                                    class="flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-white/80 hover:shadow-md transition-all duration-300 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                    <span>Analytics</span>
                                </a>
                            </div>
                        </div>
                    @endif
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-white/30">
                    <div class="flex items-center space-x-3">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                            <span class="text-white font-medium">{{ auth()->user()->initials() }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-blue-700 truncate font-medium">
                                {{ auth()->user()->role->display_name ?? 'User' }}</p>
                        </div>
                        <div class="relative">
                            <button onclick="toggleUserMenu()"
                                class="p-1 text-gray-600 hover:text-gray-800 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>

                            <!-- User Menu Dropdown -->
                            <div id="userMenu"
                                class="absolute bottom-full left-0 mb-2 w-48 bg-white/95 backdrop-blur-md rounded-xl shadow-xl border border-white/50 py-2 hidden">
                                <a href="{{ route('settings.profile') }}"
                                    class="flex items-center space-x-3 px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>Settings</span>
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center space-x-3 px-4 py-2 text-sm text-red-600 hover:bg-red-50 w-full text-left">
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
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden lg:ml-0">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200 lg:hidden">
                <div class="flex items-center justify-between h-16 px-4">
                    <button onclick="toggleSidebar()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-900">MyTalenta</h1>
                    <div class="w-6"></div> <!-- Spacer -->
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }

        // Close sidebar when clicking overlay
        document.getElementById('sidebarOverlay').addEventListener('click', toggleSidebar);

        // Close user menu when clicking outside
        document.addEventListener('click', function(e) {
            const userMenu = document.getElementById('userMenu');
            const userButton = e.target.closest('button[onclick="toggleUserMenu()"]');

            if (!userButton && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>

    @livewireScripts
</body>

</html>
