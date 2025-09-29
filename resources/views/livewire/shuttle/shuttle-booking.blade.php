<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100">
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
                                            <p class="text-xs text-gray-600 mt-1">Your shuttle booking has been
                                                approved.</p>
                                            <p class="text-xs text-gray-400 mt-1">1 day ago</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-4 text-center">
                                <button class="text-sm text-blue-600 hover:text-blue-800 font-medium">View All
                                    Notifications</button>
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

    <!-- Enhanced Page Header -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 relative overflow-hidden">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60"
            xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff"
            fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]
            animate-pulse"></div>

        <!-- Floating Elements -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-white/10 rounded-full blur-xl animate-bounce"></div>
        <div class="absolute bottom-10 right-10 w-32 h-32 bg-blue-300/20 rounded-full blur-2xl animate-pulse"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-indigo-300/15 rounded-full blur-lg animate-ping"></div>

        <!-- BCA Logo/Icon -->
        <div class="absolute top-6 right-6">
            <div
                class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center border border-white/30">
                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                </svg>
            </div>
        </div>

        <div class="px-6 py-12 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <!-- Main Title -->
                <div class="mb-6">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 tracking-tight">
                        Shuttle Bus
                        <span class="block text-blue-200 text-2xl md:text-3xl font-medium">BCA Transport</span>
                    </h1>
                    <p class="text-blue-100 text-lg md:text-xl font-medium max-w-2xl mx-auto leading-relaxed">
                        Layanan transportasi premium untuk mahasiswa penerima beasiswa BCA
                    </p>
                </div>

                <!-- Feature Highlights -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                    <div
                        class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div class="w-10 h-10 bg-blue-400/30 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-white font-semibold text-sm">Tepat Waktu</h3>
                        <p class="text-blue-100 text-xs mt-1">Jadwal terjadwal dengan presisi</p>
                    </div>

                    <div
                        class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div
                            class="w-10 h-10 bg-green-400/30 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-white font-semibold text-sm">Aman & Nyaman</h3>
                        <p class="text-blue-100 text-xs mt-1">Standar keselamatan tertinggi</p>
                    </div>

                    <div
                        class="bg-white/10 backdrop-blur-md rounded-2xl p-4 border border-white/20 hover:bg-white/15 transition-all duration-300">
                        <div
                            class="w-10 h-10 bg-purple-400/30 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <h3 class="text-white font-semibold text-sm">Lokasi Strategis</h3>
                        <p class="text-blue-100 text-xs mt-1">Rute optimal ke berbagai tujuan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-8 relative z-10">
        <!-- Alert Messages -->
        @if (session()->has('message'))
            <div
                class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-green-800 font-semibold">Berhasil!</h3>
                        <p class="text-green-700 mt-1">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-8 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 rounded-2xl p-6 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-500 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-red-800 font-semibold">Error!</h3>
                        <p class="text-red-700 mt-1">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Enhanced Booking Deadline Info -->
        <div
            class="bg-gradient-to-r from-amber-50 via-yellow-50 to-orange-50 border border-amber-200 rounded-2xl p-6 mb-8 shadow-lg hover:shadow-xl transition-all duration-300">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-amber-800 font-bold text-lg mb-2">🔔 Informasi Penting</h3>
                    <p class="text-amber-700 leading-relaxed">
                        Pemesanan shuttle untuk hari <strong>Jumat</strong> ditutup pada hari <strong>Rabu jam
                            17:00</strong>.
                        Harap lakukan pemesanan sebelum batas waktu yang ditentukan untuk menghindari keterlambatan.
                    </p>
                </div>
            </div>
        </div>

        @if ($bookingClosed)
            <!-- Enhanced Booking Closed Notice -->
            <div
                class="bg-gradient-to-r from-red-50 via-rose-50 to-pink-50 border border-red-200 rounded-2xl p-8 text-center shadow-lg">
                <div class="w-16 h-16 bg-red-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-red-800 mb-3">🚫 Pemesanan Shuttle Ditutup</h3>
                <p class="text-red-700 text-lg leading-relaxed max-w-md mx-auto">
                    Batas waktu pemesanan shuttle telah berakhir. Silakan hubungi PIC Shuttle untuk informasi lebih
                    lanjut.
                </p>
                <div class="mt-6">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        @else
            <!-- Enhanced Booking Form -->
            <form wire:submit.prevent="submit" class="space-y-8">
                <!-- Shuttle Type Selection -->
                <div
                    class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-8 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Pilih Jenis Shuttle</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Shuttle Pulang -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" wire:model.live="shuttleType" value="pulang" class="sr-only peer">
                            <div
                                class="border-2 rounded-2xl p-8 transition-all duration-300 hover:shadow-lg
                                {{ $shuttleType == 'pulang'
                                    ? 'border-blue-500 bg-gradient-to-br from-blue-50 to-blue-100 shadow-xl scale-105'
                                    : 'border-gray-200 hover:border-blue-300 hover:bg-blue-50/50' }}
                                peer-checked:border-blue-500 peer-checked:bg-gradient-to-br peer-checked:from-blue-50 peer-checked:to-blue-100">
                                <div class="text-center">
                                    <div
                                        class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center
                                        {{ $shuttleType == 'pulang' ? 'bg-blue-500' : 'bg-gray-100 group-hover:bg-blue-100' }} transition-colors duration-300">
                                        <svg class="w-8 h-8 {{ $shuttleType == 'pulang' ? 'text-white' : 'text-gray-500 group-hover:text-blue-600' }} transition-colors duration-300"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Shuttle Pulang</h3>
                                    <p class="text-gray-600 leading-relaxed">Transportasi dari asrama menuju rumah
                                        dengan kenyamanan maksimal</p>
                                </div>
                            </div>
                        </label>

                        <!-- Shuttle Kembali -->
                        <label class="relative cursor-pointer group">
                            <input type="radio" wire:model.live="shuttleType" value="kembali"
                                class="sr-only peer">
                            <div
                                class="border-2 rounded-2xl p-8 transition-all duration-300 hover:shadow-lg
                                {{ $shuttleType == 'kembali'
                                    ? 'border-green-500 bg-gradient-to-br from-green-50 to-green-100 shadow-xl scale-105'
                                    : 'border-gray-200 hover:border-green-300 hover:bg-green-50/50' }}
                                peer-checked:border-green-500 peer-checked:bg-gradient-to-br peer-checked:from-green-50 peer-checked:to-green-100">
                                <div class="text-center">
                                    <div
                                        class="w-16 h-16 mx-auto mb-4 rounded-2xl flex items-center justify-center
                                        {{ $shuttleType == 'kembali' ? 'bg-green-500' : 'bg-gray-100 group-hover:bg-green-100' }} transition-colors duration-300">
                                        <svg class="w-8 h-8 {{ $shuttleType == 'kembali' ? 'text-white' : 'text-gray-500 group-hover:text-green-600' }} transition-colors duration-300"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">Shuttle Kembali</h3>
                                    <p class="text-gray-600 leading-relaxed">Transportasi dari rumah menuju asrama
                                        dengan layanan prima</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto mb-3 {{ $shuttleType == 'kembali' ? 'text-green-600' : 'text-gray-400' }}"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="font-semibold text-gray-900">Shuttle Kembali</h3>
                    <p class="text-sm text-gray-600 mt-1">Dari rumah ke asrama</p>
                </div>
    </div>
    </label>
</div>

@error('shuttleType')
    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
@enderror
</div>

@if ($shuttleType)
    <!-- Enhanced Route Selection -->
    <div
        class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-8 hover:shadow-2xl transition-all duration-300">
        <div class="flex items-center mb-6">
            <div
                class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mr-4">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Pilih Rute Tujuan</h2>
        </div>

        @if (count($availableRoutes) > 0)
            <div class="space-y-4">
                @foreach ($availableRoutes as $route)
                    <label class="relative cursor-pointer group">
                        <input type="radio" wire:model.live="selectedRoute" value="{{ $route->id }}"
                            class="sr-only peer">
                        <div
                            class="border-2 rounded-2xl p-6 transition-all duration-300 hover:shadow-lg
                                            {{ $selectedRoute == $route->id
                                                ? 'border-purple-500 bg-gradient-to-r from-purple-50 to-purple-100 shadow-xl'
                                                : 'border-gray-200 hover:border-purple-300 hover:bg-purple-50/30' }}
                                            peer-checked:border-purple-500 peer-checked:bg-gradient-to-r peer-checked:from-purple-50 peer-checked:to-purple-100">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="w-12 h-12 rounded-2xl flex items-center justify-center mr-4
                                                        {{ $selectedRoute == $route->id ? 'bg-purple-500' : 'bg-gray-100 group-hover:bg-purple-100' }} transition-colors duration-300">
                                        @if ($selectedRoute == $route->id)
                                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-gray-400 group-hover:text-purple-600 transition-colors duration-300"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">{{ $route->destination }}</h3>
                                        @if ($route->departure_time)
                                            <p class="text-sm text-gray-600">Keberangkatan:
                                                {{ \Carbon\Carbon::parse($route->departure_time)->format('H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-500">Rute {{ $loop->iteration }}</div>
                                </div>
                            </div>
                        </div>
                    </label>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak Ada Rute Tersedia</h3>
                <p class="text-gray-600">Belum ada rute shuttle yang tersedia untuk saat ini.</p>
            </div>
        @endif

        @error('selectedRoute')
            <p class="mt-4 text-sm text-red-600 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ $message }}
            </p>
        @enderror
    </div>

    @if ($selectedRoute)
        <!-- Enhanced Date & Notes Selection -->
        <div
            class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-8 hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center mb-6">
                <div
                    class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Pemesanan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label for="bookingDate" class="flex items-center text-lg font-semibold text-gray-900 mb-3">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                            </svg>
                            Tanggal Keberangkatan
                        </label>
                        <input type="date" id="bookingDate" wire:model.live="bookingDate"
                            min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 text-lg border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 hover:border-blue-300">
                        @error('bookingDate')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="notes" class="flex items-center text-lg font-semibold text-gray-900 mb-3">
                            <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Catatan Tambahan
                        </label>
                        <textarea id="notes" wire:model.live="notes" rows="4"
                            placeholder="Tambahkan catatan khusus jika diperlukan (opsional)..."
                            class="w-full px-4 py-3 text-lg border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:ring-4 focus:ring-purple-500/20 transition-all duration-300 hover:border-purple-300 resize-none"></textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Enhanced Booking Summary & Submit -->
        <div
            class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 rounded-2xl p-8 border border-blue-100 shadow-xl">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 flex items-center">
                    <svg class="w-8 h-8 mr-3 text-blue-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Ringkasan Pemesanan
                </h2>
                <div class="text-sm text-gray-600 bg-white/60 px-3 py-1 rounded-full">
                    Langkah Terakhir
                </div>
            </div>

            @if ($selectedRoute && $bookingDate)
                @php
                    $route = $availableRoutes->where('id', $selectedRoute)->first();
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white/70 rounded-xl p-6 border border-white/50">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            Detail Perjalanan
                        </h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis Shuttle:</span>
                                <span class="font-semibold text-gray-900">{{ ucfirst($shuttleType) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tujuan:</span>
                                <span class="font-semibold text-gray-900">{{ $route->destination ?? '-' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tanggal:</span>
                                <span
                                    class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($bookingDate)->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Waktu Keberangkatan:</span>
                                <span class="font-semibold text-gray-900">
                                    {{ $route && $route->departure_time ? \Carbon\Carbon::parse($route->departure_time)->format('H:i') : 'Belum ditentukan' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/70 rounded-xl p-6 border border-white/50">
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Status Pemesanan
                        </h3>
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Formulir lengkap</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Rute tersedia</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3"></div>
                                <span class="text-gray-700">Siap untuk dipesan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed"
                        class="inline-flex items-center px-12 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-xl font-bold rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 13l4 4L19 7" />
                        </svg>
                        <span wire:loading.remove>Konfirmasi Pemesanan</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                    <p class="text-sm text-gray-600 mt-4">
                        Pastikan semua informasi sudah benar sebelum mengkonfirmasi
                    </p>
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-20 h-20 text-gray-300 mx-auto mb-6" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Lengkapi Informasi Pemesanan</h3>
                    <p class="text-gray-600 text-lg">Silakan pilih jenis shuttle, rute, dan tanggal keberangkatan untuk
                        melanjutkan</p>
                </div>
            @endif
        </div>
    @endif
@endif
</form>
@endif

<!-- Enhanced User Bookings Section -->
@if ($userBookings->count() > 0)
    <div
        class="mt-12 bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 overflow-hidden hover:shadow-2xl transition-all duration-300">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white">Riwayat Pemesanan Shuttle</h3>
            </div>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach ($userBookings as $booking)
                <div class="p-8 hover:bg-blue-50/30 transition-colors duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <div class="flex items-center mb-3">
                                <div
                                    class="w-12 h-12 rounded-2xl flex items-center justify-center mr-4
                                            {{ $booking->type === 'pulang' ? 'bg-blue-100' : 'bg-green-100' }}">
                                    @if ($booking->type === 'pulang')
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-900">
                                        {{ ucfirst($booking->type) }} - {{ $booking->shuttleRoute->destination }}
                                    </h4>
                                    <p class="text-gray-600 mt-1">
                                        {{ $booking->notes ?? 'Tidak ada catatan tambahan' }}</p>
                                </div>
                            </div>

                            <div class="flex items-center text-sm text-gray-600 space-x-6">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                                    </svg>
                                    {{ $booking->travel_date->format('d M Y') }}
                                    @if ($booking->shuttleRoute->departure_time)
                                        <span class="mx-2">•</span>
                                        {{ \Carbon\Carbon::parse($booking->shuttleRoute->departure_time)->format('H:i') }}
                                    @endif
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ $booking->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>

                        <div class="text-right ml-6">
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-2xl text-sm font-bold
                                        {{ $booking->status === 'confirmed'
                                            ? 'bg-green-100 text-green-800 border border-green-200'
                                            : ($booking->status === 'pending'
                                                ? 'bg-yellow-100 text-yellow-800 border border-yellow-200'
                                                : 'bg-gray-100 text-gray-800 border border-gray-200') }}">
                                @if ($booking->status === 'confirmed')
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                @elseif ($booking->status === 'pending')
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                @endif
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Profile dropdown toggle
        const profileBtn = document.getElementById('profileBtn');
        const profileDropdown = document.getElementById('profileDropdown');

        profileBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            document.getElementById('notificationDropdown')?.classList.add('hidden');
        });

        // Notification dropdown toggle
        const notificationBtn = document.getElementById('notificationBtn');
        const notificationDropdown = document.getElementById('notificationDropdown');

        notificationBtn?.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');
            profileDropdown?.classList.add('hidden');
        });

        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            profileDropdown?.classList.add('hidden');
            notificationDropdown?.classList.add('hidden');
        });

        // Mobile menu toggle (if needed)
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');

        mobileMenuBtn?.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    });
</script>
