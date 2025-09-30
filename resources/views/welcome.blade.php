<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>MyTalenta - Sistem Manajemen Terpadu Mahasiswa Beasiswa BCA</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-[#0066AE] via-[#005293] to-[#003d6b] min-h-screen flex flex-col overflow-x-hidden">
    <!-- Header -->
    <header class="w-full py-6 px-4 lg:px-8 relative z-10">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-7 h-7 text-[#0066AE]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-white text-xl lg:text-2xl font-bold tracking-tight">MyTalenta</h1>
                    <p class="text-white/80 text-sm font-medium">Sistem Manajemen Terpadu Mahasiswa Beasiswa BCA</p>
                </div>
            </div>

            @auth
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg px-4 py-2">
                        <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <span class="text-white font-medium text-sm">{{ Auth::user()->name }}</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit"
                            class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition-all duration-200 text-sm font-medium hover:shadow-lg">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}"
                        class="bg-white/20 hover:bg-white/30 text-white px-6 py-2.5 rounded-lg transition-all duration-200 text-sm font-medium hover:shadow-lg">
                        Login
                    </a>
                </div>
            @endauth
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 flex items-center justify-center px-4 lg:px-8 py-8 relative">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 left-10 w-32 h-32 bg-white rounded-full"></div>
            <div class="absolute top-40 right-20 w-24 h-24 bg-white rounded-full"></div>
            <div class="absolute bottom-32 left-1/4 w-20 h-20 bg-white rounded-full"></div>
            <div class="absolute bottom-20 right-10 w-16 h-16 bg-white rounded-full"></div>
        </div>

        <div class="max-w-7xl mx-auto text-center relative z-10">
            <!-- Hero Section -->
            <div class="mb-16">
                @auth
                    <!-- Authenticated User Hero -->
                    <h2 class="text-4xl lg:text-6xl font-bold text-white mb-4 leading-tight">
                        Selamat Datang Kembali, {{ Auth::user()->name }}
                    </h2>
                    <p class="text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed font-light">
                        Anda adalah {{ Auth::user()->role?->display_name ?? 'Mahasiswa' }} di
                        {{ Auth::user()->batch?->program?->name ?? 'Program' }} {{ Auth::user()->batch?->name ?? 'Batch' }}
                    </p>
                @else
                    <!-- Guest Hero -->
                    <h2 class="text-5xl lg:text-7xl font-bold text-white mb-6 leading-tight">
                        Pilih Dashboard Anda
                    </h2>
                    <p class="text-xl lg:text-2xl text-white/90 max-w-3xl mx-auto leading-relaxed font-light">
                        Akses platform terpadu untuk mengelola kegiatan akademik dan fasilitas mahasiswa beasiswa BCA
                    </p>
                @endauth
            </div>

            <!-- Dashboard Selection Cards -->
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12 max-w-5xl mx-auto">
                <!-- BCA Learning Institute Card -->
                <div class="group h-full">
                    <a href="{{ route('dashboard') }}"
                        class="block h-full bg-gradient-to-br from-blue-500/20 via-blue-600/15 to-blue-700/20 backdrop-blur-sm border border-blue-300/30 rounded-3xl p-8 lg:p-10 hover:from-blue-500/30 hover:via-blue-600/25 hover:to-blue-700/30 hover:border-blue-300/50 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-2xl hover:shadow-blue-500/20">
                        <div class="flex flex-col items-center text-center h-full">
                            <!-- Icon -->
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-blue-400/30 to-blue-600/30 rounded-2xl flex items-center justify-center mb-8 group-hover:from-blue-400/40 group-hover:to-blue-600/40 transition-all duration-300 shadow-lg">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>

                            <!-- Content -->
                            <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4">
                                BCA Learning Institute
                            </h3>
                            <p class="text-white/80 text-lg mb-8 leading-relaxed flex-grow">
                                Kelola kegiatan akademik, peminjaman ruangan, absensi, dan fasilitas pendukung
                                pembelajaran mahasiswa PPTI dan PPBP
                            </p>

                            <!-- Features List -->
                            <div class="text-left w-full max-w-sm mb-8 flex-grow">
                                <div class="space-y-3 text-white/70 text-sm">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Peminjaman Ruang Diskusi
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Sistem Absensi Terpadu
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Pemesanan Shuttle Bus
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Pelaporan Kerusakan
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <div class="mt-auto">
                                <span
                                    class="inline-flex items-center px-8 py-4 bg-white text-[#0066AE] font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 group-hover:shadow-xl text-base">
                                    Masuk Dashboard
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Rumah Talenta BCA Card -->
                <div class="group h-full">
                    <a href="{{ route('rumah-talenta') }}"
                        class="block h-full bg-gradient-to-br from-green-500/20 via-emerald-600/15 to-teal-700/20 backdrop-blur-sm border border-green-300/30 rounded-3xl p-8 lg:p-10 hover:from-green-500/30 hover:via-emerald-600/25 hover:to-teal-700/30 hover:border-green-300/50 transition-all duration-500 transform hover:-translate-y-3 hover:shadow-2xl hover:shadow-green-500/20">
                        <div class="flex flex-col items-center text-center h-full">
                            <!-- Icon -->
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-green-400/30 to-emerald-600/30 rounded-2xl flex items-center justify-center mb-8 group-hover:from-green-400/40 group-hover:to-emerald-600/40 transition-all duration-300 shadow-lg">
                                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>

                            <!-- Content -->
                            <h3 class="text-2xl lg:text-3xl font-bold text-white mb-4">
                                Rumah Talenta BCA
                            </h3>
                            <p class="text-white/80 text-lg mb-8 leading-relaxed flex-grow">
                                Kelola fasilitas asrama, peminjaman ruangan umum, booking mesin cuci, dan pelaporan
                                kerusakan di Rumah Talenta BCA
                            </p>

                            <!-- Features List -->
                            <div class="text-left w-full max-w-sm mb-8 flex-grow">
                                <div class="space-y-3 text-white/70 text-sm">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-green-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Peminjaman Ruangan Asrama
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-green-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Booking Fasilitas Khusus
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-green-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Sistem Kios Talenta
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-3 text-green-300" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Pelaporan Kerusakan Fasilitas
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <div class="mt-auto">
                                <span
                                    class="inline-flex items-center px-8 py-4 bg-white text-[#0066AE] font-semibold rounded-xl hover:bg-gray-50 transition-all duration-200 group-hover:shadow-xl text-base">
                                    Masuk Dashboard
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Footer Text -->
            <div class="mt-16 text-white/60 text-sm">
                <p class="font-medium">© 2025 PT Bank Central Asia Tbk. All rights reserved.</p>
            </div>
        </div>
    </main>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>

</html>
