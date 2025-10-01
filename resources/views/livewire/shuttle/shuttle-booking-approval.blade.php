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
                        <p class="text-xs text-gray-500 -mt-1">Shuttle Booking Approval</p>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                        Dashboard
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
                    <div class="flex items-center space-x-2 p-1 rounded-lg">
                        <div
                            class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-medium text-sm">{{ auth()->user()->initials() }}</span>
                        </div>
                        <div class="hidden sm:block text-left">
                            <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500">PIC {{ strtoupper($filterProgram ?? 'PPTI/PPBP') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60"
            xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff"
            fill-opacity="0.05"%3E%3Ccircle cx="30" cy="30" r="2" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]
            animate-pulse"></div>

        <div class="px-6 py-12 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 tracking-tight">
                    Persetujuan Pemesanan Shuttle
                </h1>
                <p class="text-blue-100 text-lg md:text-xl font-medium max-w-2xl mx-auto leading-relaxed">
                    Kelola dan setujui pemesanan shuttle mahasiswa {{ $filterProgram ?? 'PPTI/PPBP' }}
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-8 relative z-10">
        <!-- Alert Messages -->
        @if (session()->has('message'))
            <div
                class="mb-8 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-2xl p-6 shadow-lg animate-fade-in">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-green-800 font-semibold">Berhasil!</h3>
                        <p class="text-green-700 mt-1">{{ session('message') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div
                class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-6 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-amber-500 rounded-2xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Menunggu Persetujuan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-6 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 rounded-2xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Disetujui</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['approved'] }}</p>
                    </div>
                </div>
            </div>

            <div
                class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-6 hover:shadow-2xl transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-500 rounded-2xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-600">Ditolak</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['rejected'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 p-6 mb-8">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex items-center space-x-2">
                    <label for="filter_status" class="text-sm font-medium text-gray-700">Status:</label>
                    <select id="filter_status" wire:model.live="filterStatus"
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending">Menunggu Persetujuan</option>
                        <option value="approved">Disetujui</option>
                        <option value="rejected">Ditolak</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Bookings Table -->
        <div
            class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/50 overflow-hidden hover:shadow-2xl transition-all duration-300">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-white">Daftar Pemesanan</h3>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Mahasiswa</th>
                            <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Rute</th>
                            <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal</th>
                            <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis</th>
                            <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dibuat</th>
                            <th class="px-8 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition-colors duration-300">
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                                            <span
                                                class="text-white font-medium text-sm">{{ $booking->user->initials() }}</span>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->user->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $booking->user->program->name ?? 'N/A' }} -
                                                {{ $booking->user->batch->name ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->shuttleRoute->destination }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->shuttleRoute->name }}</div>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $booking->travel_date->format('d M Y') }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $booking->type === 'pulang' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($booking->type) }}
                                    </span>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if ($booking->approval_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->approval_status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        @if ($booking->approval_status === 'pending')
                                            Menunggu
                                        @elseif($booking->approval_status === 'approved')
                                            Disetujui
                                        @else
                                            Ditolak
                                        @endif
                                    </span>
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->created_at->diffForHumans() }}
                                </td>
                                <td class="px-8 py-4 whitespace-nowrap text-sm font-medium">
                                    @if ($booking->approval_status === 'pending')
                                        <button wire:click="openApprovalModal({{ $booking->id }})"
                                            class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition-colors duration-300">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Proses
                                        </button>
                                    @else
                                        <span class="text-gray-400 text-xs">
                                            @if ($booking->approved_at)
                                                {{ $booking->approved_at->diffForHumans() }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-12 text-center">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada pemesanan</h3>
                                    <p class="text-gray-600">Belum ada pemesanan shuttle yang perlu diproses.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($bookings->hasPages())
                <div class="px-8 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>

        <!-- Approval Modal -->
        @if ($showApprovalModal && $selectedBooking)
            <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6">
                        <div class="flex items-center justify-between">
                            <h3 class="text-2xl font-bold text-white">Proses Persetujuan</h3>
                            <button wire:click="closeModal" class="text-white hover:text-gray-200 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-8">
                        <!-- Booking Details -->
                        <div class="bg-gray-50 rounded-xl p-6 mb-6">
                            <h4 class="text-lg font-bold text-gray-900 mb-4">Detail Pemesanan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Mahasiswa</p>
                                    <p class="font-medium">{{ $selectedBooking->user->name }}</p>
                                    <p class="text-sm text-gray-500">
                                        {{ $selectedBooking->user->program->name ?? 'N/A' }} -
                                        {{ $selectedBooking->user->batch->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Rute</p>
                                    <p class="font-medium">{{ $selectedBooking->shuttleRoute->destination }}</p>
                                    <p class="text-sm text-gray-500">{{ $selectedBooking->shuttleRoute->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Tanggal & Jenis</p>
                                    <p class="font-medium">{{ $selectedBooking->travel_date->format('d M Y') }}</p>
                                    <p class="text-sm text-gray-500">{{ ucfirst($selectedBooking->type) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Waktu Keberangkatan</p>
                                    <p class="font-medium">
                                        {{ $selectedBooking->shuttleRoute->departure_time ? $selectedBooking->shuttleRoute->departure_time->format('H:i') : 'Belum ditentukan' }}
                                    </p>
                                </div>
                            </div>
                            @if ($selectedBooking->notes)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">Catatan</p>
                                    <p class="text-sm bg-white p-3 rounded-lg border">{{ $selectedBooking->notes }}
                                    </p>
                                </div>
                            @endif
                        </div>

                        <!-- Approval Form -->
                        <form class="space-y-6">
                            <div>
                                <label for="approval_notes" class="block text-sm font-semibold text-gray-900 mb-2">
                                    Catatan Persetujuan (Opsional)
                                </label>
                                <textarea id="approval_notes" wire:model="approvalNotes" rows="4"
                                    placeholder="Tambahkan catatan untuk mahasiswa..."
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-blue-500 focus:ring-4 focus:ring-blue-500/20 transition-all duration-300 resize-none"></textarea>
                                @error('approvalNotes')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                                <button type="button" wire:click="closeModal"
                                    class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-xl transition-all duration-300">
                                    Batal
                                </button>
                                <button type="button" wire:click="rejectBooking"
                                    class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300">
                                    Tolak Pemesanan
                                </button>
                                <button type="button" wire:click="approveBooking"
                                    class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-300">
                                    Setujui Pemesanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
