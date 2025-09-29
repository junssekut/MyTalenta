@extends(auth()->user()->role->name === 'student' ? 'layouts.mobile' : 'layouts.sidebar')

@php
    $greeting =
        now()->format('H') < 12
            ? 'Pagi'
            : (now()->format('H') < 15
                ? 'Siang'
                : (now()->format('H') < 18
                    ? 'Sore'
                    : 'Malam'));
    $motivationalQuotes = [
        'Hari ini adalah kesempatan baru untuk menjadi lebih baik!',
        'Setiap langkah kecil adalah progress yang berharga.',
        'Tetap semangat, kamu pasti bisa!',
        'Kesuksesan dimulai dari konsistensi setiap hari.',
        'Percayai prosesmu, hasil akan mengikuti.',
    ];
    $motivationalQuote = $motivationalQuotes[array_rand($motivationalQuotes)]; // Sample data - should come from
    $activeBookings = 3;
    $attendanceRate = 95;
    $upcomingEvents = 2;
    $notifications = 5;
    $recentActivity = collect([]);
    $announcements = collect([]);
@endphp

@section('title', 'Dashboard MyTalenta')
@section('content') @if (auth()->user()->role->name === 'student')
    <!-- Mobile Dashboard for Students -->
    @livewire('dashboard', ['greeting' => $greeting, 'motivationalQuote' => $motivationalQuote])
@else
    <!-- Desktop/Sidebar Dashboard for Admin/PIC -->
    <div class="p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Students</p>
                        <p class="text-2xl font-semibold text-gray-900">1,234</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Active Bookings</p>
                        <p class="text-2xl font-semibold text-gray-900">156</p>
                    </div>
                </div>
            </div>

            @if (auth()->user()->role->name !== 'student')
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pending Reports</p>
                            <p class="text-2xl font-semibold text-gray-900">23</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Shuttle Trips</p>
                        <p class="text-2xl font-semibold text-gray-900">45</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if (auth()->user()->role !== 'mahasiswa')
                <!-- Recent Activity -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">New student registration</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-green-600 rounded-full mt-2 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">Room booking approved</p>
                                <p class="text-xs text-gray-500">4 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-yellow-600 rounded-full mt-2 flex-shrink-0"></div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-gray-900">Maintenance report submitted</p>
                                <p class="text-xs text-gray-500">1 day ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    @if (auth()->user()->role->name !== 'student')
                        <a href="{{ route('admin.users') }}"
                            class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                            </svg>
                            <span class="text-sm font-medium">Manage Users</span>
                        </a>
                    @endif
                    <a href="{{ route('admin.bookings') }}"
                        class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                        </svg>
                        <span class="text-sm font-medium">View Bookings</span>
                    </a>
                    @if (auth()->user()->role->name !== 'student')
                        <a href="{{ route('admin.reports') }}"
                            class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium">Reports</span>
                        </a>
                        <a href="{{ route('admin.settings') }}"
                            class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-sm font-medium">Settings</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endif
@endsection
