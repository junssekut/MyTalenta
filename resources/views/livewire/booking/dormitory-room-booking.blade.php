<div class="min-h-screen bg-gray-50">
    <!-- Page Header -->
    <div class="bg-gradient-to-br from-blue-50 via-indigo-100 to-blue-200 relative overflow-hidden">
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

        <div class="px-4 py-8 relative z-10">
            <div class="max-w-7xl mx-auto">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Peminjaman Ruangan Asrama</h1>
                    <p class="text-blue-700 text-lg font-medium">Formulir pengajuan peminjaman ruangan di Rumah Talenta
                        BCA</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('message') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-8">
            <!-- Pilih Ruangan -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Pilih Ruangan</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($availableRooms as $room)
                        <label class="relative cursor-pointer">
                            <input type="radio" wire:model.live="roomId" value="{{ $room->id }}" class="sr-only">
                            <div
                                class="border rounded-lg p-4 transition-all
                            {{ $roomId == $room->id ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $room->name }}</h3>
                                        <p class="text-sm text-gray-600">{{ $room->location }}</p>
                                        <p class="text-xs text-gray-500">Kapasitas: {{ $room->capacity }} orang</p>
                                    </div>
                                    @if ($roomId == $room->id)
                                        <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('roomId')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Detail Peminjaman -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Peminjaman</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tanggal -->
                    <div>
                        <label for="bookingDate" class="block text-sm font-medium text-gray-700 mb-2">
                            Tanggal Peminjaman
                        </label>
                        <input type="date" id="bookingDate" wire:model.live="bookingDate" min="{{ date('Y-m-d') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('bookingDate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah Peserta -->
                    <div>
                        <label for="participantCount" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Peserta
                        </label>
                        <input type="number" id="participantCount" wire:model="participantCount" min="1"
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        @error('participantCount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Time Slots -->
                @if ($roomId && $bookingDate)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Slot Waktu (2 jam per slot)
                        </label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                            @foreach ($availableTimeSlots as $slot)
                                <label class="relative cursor-pointer">
                                    <input type="radio" wire:model="selectedTimeSlot" value="{{ $slot['start'] }}"
                                        class="sr-only" {{ $slot['available'] ? '' : 'disabled' }}>
                                    <div
                                        class="border rounded-lg p-3 text-center transition-all
                                {{ !$slot['available']
                                    ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                    : ($selectedTimeSlot == $slot['start']
                                        ? 'border-blue-500 bg-blue-50 text-blue-700'
                                        : 'border-gray-200 hover:border-gray-300') }}">
                                        <div class="text-sm font-medium">{{ $slot['start'] }} - {{ $slot['end'] }}
                                        </div>
                                        @if (!$slot['available'])
                                            <div class="text-xs text-red-500 mt-1">Terpakai</div>
                                        @endif
                                    </div>
                                </label>
                            @endforeach
                        </div>
                        @error('selectedTimeSlot')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Alasan Peminjaman -->
                <div class="mt-6">
                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Peminjaman
                    </label>
                    <textarea id="purpose" wire:model="purpose" rows="3"
                        placeholder="Jelaskan tujuan dan kegiatan yang akan dilakukan..."
                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                    @error('purpose')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-600">
                        <p>• Peminjaman akan diajukan ke Core Team PIC ruangan</p>
                        <p>• Konfirmasi akan dikirim melalui notifikasi</p>
                        <p>• Slot waktu hanya berlaku untuk durasi 2 jam</p>
                    </div>
                    <button type="submit" wire:loading.attr="disabled"
                        class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                        <span wire:loading.remove>Ajukan Peminjaman</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Booking History -->
        @if ($userBookings->count() > 0)
            <div class="mt-8 bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Riwayat Peminjaman Anda</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($userBookings as $booking)
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $booking->room->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $booking->purpose }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $booking->start_time->format('d M Y, H:i') }} -
                                        {{ $booking->end_time->format('H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $booking->status === 'approved'
                                    ? 'bg-green-100 text-green-800'
                                    : ($booking->status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $booking->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
