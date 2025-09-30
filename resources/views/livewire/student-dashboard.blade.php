<div class="pb-20">
    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-blue-50 via-indigo-100 to-blue-200 text-gray-900 relative overflow-hidden">
        <!-- Subtle Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="40" height="40" viewBox="0 0 40 40"
            xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="%230066AE" fill-opacity="0.05" fill-rule="evenodd"%3E%3Cpath
            d="M20 20c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10zm10 0c0-5.5-4.5-10-10-10s-10 4.5-10 10 4.5 10 10 10 10-4.5 10-10z"
            /%3E%3C/g%3E%3C/svg%3E')]"></div>

        <!-- BCA Blue Accent -->
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600/10 rounded-full -translate-y-32 translate-x-32">
        </div>
        <div class="absolute bottom-0 left-0 w-48 h-48 bg-indigo-600/10 rounded-full translate-y-24 -translate-x-24">
        </div>

        <div class="px-6 py-8 relative z-10">
            <!-- Welcome Section -->
            <div class="text-center mb-8">
                <div
                    class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 border-2 border-white border-opacity-30">
                    <span
                        class="text-white font-bold text-xl">{{ auth()->check() && is_object(auth()->user()) ? auth()->user()->initials() : 'U' }}</span>
                </div>
                <h1 class="text-2xl font-bold mb-2 text-gray-900">
                    Selamat {{ $greeting }},
                    {{ auth()->check() && is_object(auth()->user()) ? auth()->user()->name : 'User' }}!
                </h1>
                <p class="text-blue-700 text-sm font-medium">
                    {{ $motivationalQuote }}
                </p>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-2 gap-6 mb-8">
                <!-- Active Bookings -->
                <div
                    class="bg-white/80 backdrop-blur-md rounded-2xl p-6 text-center border border-white/50 shadow-xl hover:bg-white/90 transition-all duration-300">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-1">{{ $activeBookings ?? 0 }}</div>
                    <div class="text-blue-600 text-xs font-medium uppercase tracking-wide">Active Bookings</div>
                </div>

                <!-- Attendance Rate -->
                <div
                    class="bg-white/80 backdrop-blur-md rounded-2xl p-6 text-center border border-white/50 shadow-xl hover:bg-white/90 transition-all duration-300">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 mb-1">{{ $attendanceRate ?? 0 }}<span
                            class="text-lg">%</span></div>
                    <div class="text-blue-600 text-xs font-medium uppercase tracking-wide">Attendance Rate</div>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="bg-white/80 backdrop-blur-md rounded-2xl p-6 border border-white/50 shadow-xl">
                <h3 class="font-semibold mb-6 flex items-center text-gray-900">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                        </svg>
                    </div>
                    Jadwal Hari Ini
                </h3>
                <div class="space-y-4">
                    @if ($todaySchedule && $todaySchedule->count() > 0)
                        @foreach ($todaySchedule as $schedule)
                            <div
                                class="flex items-center justify-between p-4 bg-blue-50/80 rounded-xl border border-blue-100/50">
                                <div class="flex items-center space-x-3">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                    <span
                                        class="text-gray-900 text-sm font-medium">{{ $schedule['title'] ?? 'Schedule Item' }}</span>
                                </div>
                                <span class="text-blue-700 text-sm font-medium">{{ $schedule['time'] ?? '' }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                            </svg>
                            <p class="text-gray-500 text-sm">Tidak ada jadwal hari ini</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Grid -->
    <div class="px-8 py-10">
        <h2 class="text-xl font-bold text-gray-900 mb-8 flex items-center">
            <div
                class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            Quick Access
        </h2>

        <div class="grid grid-cols-2 gap-8 mb-10">
            <!-- Book Room -->
            <a href="{{ route('booking.room') }}"
                class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-blue-50 to-indigo-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg relative z-10">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                    </svg>
                </div>
                <h3
                    class="font-bold text-gray-900 text-sm mb-1 relative z-10 group-hover:text-blue-600 transition-colors">
                    Book</h3>
                <p class="text-gray-600 text-xs relative z-10">Room</p>
            </a>

            <!-- Shuttle -->
            <a href="{{ route('shuttle.booking') }}"
                class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-purple-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg relative z-10">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                </div>
                <h3
                    class="font-bold text-gray-900 text-sm mb-1 relative z-10 group-hover:text-purple-600 transition-colors">
                    Shuttle</h3>
                <p class="text-gray-600 text-xs relative z-10">Booking</p>
            </a>

            <!-- Reports -->
            <a href="{{ route('reports.create') }}"
                class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-orange-50 to-red-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg relative z-10">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3
                    class="font-bold text-gray-900 text-sm mb-1 relative z-10 group-hover:text-orange-600 transition-colors">
                    Create</h3>
                <p class="text-gray-600 text-xs relative z-10">Report</p>
            </a>

            <!-- Facility Damage Report -->
            <a href="{{ route('reports.facility') }}"
                class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-8 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden relative">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-red-50 to-pink-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                </div>
                <div
                    class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg relative z-10">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                    </svg>
                </div>
                <h3
                    class="font-bold text-gray-900 text-sm mb-1 relative z-10 group-hover:text-red-600 transition-colors">
                    Report</h3>
                <p class="text-gray-600 text-xs relative z-10">Damage</p>
            </a>
        </div>

        <!-- Recent Activity -->
        @if ($recentActivity && $recentActivity->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Recent Activity
                </h3>
                <div class="space-y-4">
                    @foreach ($recentActivity as $activity)
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl">
                            <div
                                class="w-10 h-10 rounded-full flex items-center justify-center
                        @if ($activity['icon'] === 'booking') bg-blue-100
                        @elseif($activity['icon'] === 'attendance') bg-green-100
                        @else bg-gray-100 @endif">
                                @if ($activity['icon'] === 'booking')
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                                    </svg>
                                @elseif($activity['icon'] === 'attendance')
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $activity['title'] ?? 'Activity' }}
                                </p>
                                <p class="text-xs text-gray-600">{{ $activity['description'] ?? '' }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $activity['time'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Announcements -->
        @if ($announcements && $announcements->count() > 0)
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                    <div
                        class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-orange-600 rounded-lg flex items-center justify-center mr-3 shadow-md">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    Announcements
                </h3>
                <div class="space-y-4">
                    @foreach ($announcements as $announcement)
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <h4 class="font-semibold text-gray-900 mb-2">{{ $announcement->title }}</h4>
                            <p class="text-sm text-gray-700 mb-2">{{ Str::limit($announcement->content, 100) }}</p>
                            <p class="text-xs text-gray-500">{{ $announcement->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
