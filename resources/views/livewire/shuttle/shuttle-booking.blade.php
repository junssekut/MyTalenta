<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Shuttle Bus BCA</h1>
                    <p class="text-green-100 mt-1">Pemesanan Transportasi Shuttle</p>
                </div>
                <a href="{{ route('dashboard.learning-institute') }}" 
                   class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                {{ session('error') }}
            </div>
        @endif

        <!-- Booking Deadline Info -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <h3 class="text-yellow-800 font-semibold">Informasi Penting</h3>
                    <p class="text-yellow-700 text-sm mt-1">
                        Pemesanan shuttle untuk hari Jumat ditutup pada hari Rabu jam 17:00. 
                        Harap lakukan pemesanan sebelum batas waktu yang ditentukan.
                    </p>
                </div>
            </div>
        </div>

        @if($bookingClosed)
        <!-- Booking Closed Notice -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-6 text-center">
            <svg class="w-12 h-12 text-red-500 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <h3 class="text-lg font-semibold text-red-800 mb-2">Pemesanan Shuttle Ditutup</h3>
            <p class="text-red-700">Batas waktu pemesanan shuttle telah berakhir. Silakan hubungi PIC Shuttle untuk informasi lebih lanjut.</p>
        </div>
        @else
        <!-- Booking Form -->
        <form wire:submit.prevent="submit" class="space-y-8">
            <!-- Shuttle Type Selection -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Jenis Shuttle</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Shuttle Pulang -->
                    <label class="relative cursor-pointer">
                        <input type="radio" 
                               wire:model.live="shuttleType" 
                               value="pulang" 
                               class="sr-only">
                        <div class="border rounded-lg p-6 transition-all
                            {{ $shuttleType == 'pulang' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-3 {{ $shuttleType == 'pulang' ? 'text-blue-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                </svg>
                                <h3 class="font-semibold text-gray-900">Shuttle Pulang</h3>
                                <p class="text-sm text-gray-600 mt-1">Dari asrama ke rumah</p>
                            </div>
                        </div>
                    </label>

                    <!-- Shuttle Kembali -->
                    <label class="relative cursor-pointer">
                        <input type="radio" 
                               wire:model.live="shuttleType" 
                               value="kembali" 
                               class="sr-only">
                        <div class="border rounded-lg p-6 transition-all
                            {{ $shuttleType == 'kembali' ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="text-center">
                                <svg class="w-12 h-12 mx-auto mb-3 {{ $shuttleType == 'kembali' ? 'text-green-600' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd"/>
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

            @if($shuttleType)
            <!-- Route Selection -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Pilih Rute/Tujuan</h2>
                
                @if(count($availableRoutes) > 0)
                <div class="space-y-3">
                    @foreach($availableRoutes as $route)
                    <label class="relative cursor-pointer">
                        <input type="radio" 
                               wire:model="selectedRoute" 
                               value="{{ $route->id }}" 
                               class="sr-only">
                        <div class="border rounded-lg p-4 transition-all flex items-center justify-between
                            {{ $selectedRoute == $route->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <div class="flex items-center">
                                <div class="mr-4">
                                    @if($selectedRoute == $route->id)
                                        <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full"></div>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $route->destination }}</h3>
                                    @if($route->description)
                                        <p class="text-sm text-gray-600">{{ $route->description }}</p>
                                    @endif
                                    <p class="text-xs text-gray-500">
                                        Jadwal: {{ $route->departure_time ? \Carbon\Carbon::parse($route->departure_time)->format('H:i') : 'Belum ditentukan' }}
                                    </p>
                                </div>
                            </div>
                            @if($route->capacity)
                            <div class="text-right">
                                <span class="text-sm text-gray-600">Kapasitas: {{ $route->capacity }}</span>
                            </div>
                            @endif
                        </div>
                    </label>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <p>Tidak ada rute yang tersedia untuk jenis shuttle ini</p>
                </div>
                @endif
                
                @error('selectedRoute')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            @if($selectedRoute)
            <!-- Date Selection -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Tanggal Keberangkatan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="bookingDate" class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Tanggal
                        </label>
                        <input type="date" 
                               id="bookingDate"
                               wire:model="bookingDate"
                               min="{{ date('Y-m-d') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('bookingDate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Catatan (Opsional)
                        </label>
                        <textarea id="notes"
                                  wire:model="notes"
                                  rows="3"
                                  placeholder="Tambahkan catatan jika diperlukan..."
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        @if($selectedRoute && $bookingDate)
                            @php
                                $route = $availableRoutes->where('id', $selectedRoute)->first();
                            @endphp
                            <p><strong>Jenis:</strong> {{ ucfirst($shuttleType) }}</p>
                            <p><strong>Tujuan:</strong> {{ $route->destination ?? '-' }}</p>
                            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($bookingDate)->format('d M Y') }}</p>
                            <p><strong>Jam:</strong> {{ $route && $route->departure_time ? \Carbon\Carbon::parse($route->departure_time)->format('H:i') : 'Belum ditentukan' }}</p>
                        @else
                            <p>Silakan lengkapi semua informasi di atas</p>
                        @endif
                    </div>
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        <span wire:loading.remove>Pesan Shuttle</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
            @endif
            @endif
        </form>
        @endif

        <!-- User Bookings -->
        @if($userBookings->count() > 0)
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Booking Shuttle Saya</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($userBookings as $booking)
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-semibold text-gray-900">
                                {{ ucfirst($booking->shuttle_type) }} - {{ $booking->route->destination }}
                            </h4>
                            <p class="text-sm text-gray-600">{{ $booking->notes ?? 'Tidak ada catatan' }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $booking->booking_date->format('d M Y') }}
                                @if($booking->route->departure_time)
                                    , {{ \Carbon\Carbon::parse($booking->route->departure_time)->format('H:i') }}
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                   ($booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                            <p class="text-xs text-gray-500 mt-1">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
