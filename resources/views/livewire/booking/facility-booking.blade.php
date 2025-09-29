<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Booking Fasilitas</h1>
                    <p class="text-gray-600 mt-1">Pemesanan Mesin Cuci & Dapur Bersama</p>
                </div>
                <a href="{{ route('rumah-talenta') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session()->has('message'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('message') }}
            </div>
        @endif

        <!-- Facility Selection -->
        <div class="bg-white rounded-lg shadow mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-semibold text-gray-900">Pilih Fasilitas</h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Mesin Cuci Pria -->
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model.live="facilityType" value="washing_machine_male"
                            class="sr-only">
                        <div
                            class="border rounded-lg p-6 text-center transition-all
                            {{ $facilityType == 'washing_machine_male' ? 'border-blue-500 bg-blue-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <svg class="w-12 h-12 mx-auto mb-3 {{ $facilityType == 'washing_machine_male' ? 'text-blue-600' : 'text-gray-400' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                            <h3 class="font-semibold text-gray-900">Mesin Cuci Pria</h3>
                            <p class="text-sm text-gray-600 mt-1">Area pria lantai bawah</p>
                            <div class="mt-2 text-xs text-gray-500">
                                Max {{ $maxWashingMachineMale }} slot per waktu
                            </div>
                        </div>
                    </label>

                    <!-- Mesin Cuci Wanita -->
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model.live="facilityType" value="washing_machine_female"
                            class="sr-only">
                        <div
                            class="border rounded-lg p-6 text-center transition-all
                            {{ $facilityType == 'washing_machine_female' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <svg class="w-12 h-12 mx-auto mb-3 {{ $facilityType == 'washing_machine_female' ? 'text-pink-600' : 'text-gray-400' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" />
                            </svg>
                            <h3 class="font-semibold text-gray-900">Mesin Cuci Wanita</h3>
                            <p class="text-sm text-gray-600 mt-1">Area wanita lantai atas</p>
                            <div class="mt-2 text-xs text-gray-500">
                                Max {{ $maxWashingMachineFemale }} slot per waktu
                            </div>
                        </div>
                    </label>

                    <!-- Dapur Bersama -->
                    <label class="relative cursor-pointer">
                        <input type="radio" wire:model.live="facilityType" value="kitchen" class="sr-only">
                        <div
                            class="border rounded-lg p-6 text-center transition-all
                            {{ $facilityType == 'kitchen' ? 'border-orange-500 bg-orange-50' : 'border-gray-200 hover:border-gray-300' }}">
                            <svg class="w-12 h-12 mx-auto mb-3 {{ $facilityType == 'kitchen' ? 'text-orange-600' : 'text-gray-400' }}"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5.5 16a3.5 3.5 0 01-.369-6.98 4 4 0 117.753-1.977A4.5 4.5 0 1113.5 16h-8z" />
                            </svg>
                            <h3 class="font-semibold text-gray-900">Dapur Bersama</h3>
                            <p class="text-sm text-gray-600 mt-1">Lantai dasar</p>
                            <div class="mt-2 text-xs text-gray-500">
                                Max {{ $maxKitchenUsers }} pengguna per slot
                            </div>
                        </div>
                    </label>
                </div>

                @error('facilityType')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        @if ($facilityType)
            <form wire:submit.prevent="submit" class="space-y-8">
                <!-- Date Selection -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Pilih Tanggal</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="bookingDate" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Booking
                            </label>
                            <input type="date" id="bookingDate" wire:model.live="bookingDate"
                                min="{{ $minDate }}"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('bookingDate')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Booking minimal H+1 ({{ $minDate }})</p>
                        </div>

                        @if ($facilityType === 'kitchen')
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">
                                    Durasi Penggunaan
                                </label>
                                <select id="duration" wire:model="duration"
                                    class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">Pilih durasi</option>
                                    <option value="1">1 jam</option>
                                    <option value="2">2 jam</option>
                                    <option value="3">3 jam</option>
                                </select>
                                @error('duration')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Time Slots -->
                @if ($bookingDate)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Pilih Slot Waktu</h2>

                        @if (count($availableTimeSlots) > 0)
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach ($availableTimeSlots as $slot)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" wire:model="selectedTimeSlot"
                                            value="{{ $slot['start'] }}" class="sr-only"
                                            {{ $slot['available'] ? '' : 'disabled' }}>
                                        <div
                                            class="border rounded-lg p-3 text-center transition-all
                            {{ !$slot['available']
                                ? 'bg-gray-100 text-gray-400 cursor-not-allowed'
                                : ($selectedTimeSlot == $slot['start']
                                    ? 'border-blue-500 bg-blue-50 text-blue-700'
                                    : 'border-gray-200 hover:border-gray-300') }}">
                                            <div class="text-sm font-medium">{{ $slot['start'] }} -
                                                {{ $slot['end'] }}</div>
                                            <div class="text-xs mt-1">
                                                @if ($slot['available'])
                                                    <span class="text-green-600">{{ $slot['available_count'] }} slot
                                                        tersedia</span>
                                                @else
                                                    <span class="text-red-500">Penuh</span>
                                                @endif
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                <p>Tidak ada slot yang tersedia untuk tanggal ini</p>
                            </div>
                        @endif

                        @error('selectedTimeSlot')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <!-- Additional Information -->
                @if ($selectedTimeSlot)
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Tambahan</h2>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan (Opsional)
                            </label>
                            <textarea id="notes" wire:model="notes" rows="3" placeholder="Tambahkan catatan jika diperlukan..."
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500"></textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Facility Rules -->
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 mb-2">Aturan Penggunaan:</h4>
                            <ul class="text-sm text-yellow-700 space-y-1">
                                @if (in_array($facilityType, ['washing_machine_male', 'washing_machine_female']))
                                    <li>• Maksimal
                                        {{ $facilityType === 'washing_machine_male' ? $maxWashingMachineMale : $maxWashingMachineFemale }}
                                        slot per waktu</li>
                                    <li>• Durasi penggunaan maksimal 2 jam</li>
                                    <li>• Harap membersihkan mesin setelah digunakan</li>
                                    <li>• Booking minimal H+1 dari hari ini</li>
                                @else
                                    <li>• Maksimal {{ $maxKitchenUsers }} pengguna bersamaan</li>
                                    <li>• Harap membersihkan area dapur setelah digunakan</li>
                                    <li>• Tidak boleh memasak makanan berbau menyengat</li>
                                    <li>• Booking minimal H+1 dari hari ini</li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <p><strong>Fasilitas:</strong> {{ $this->getFacilityName() }}</p>
                                <p><strong>Tanggal:</strong>
                                    {{ $bookingDate ? \Carbon\Carbon::parse($bookingDate)->format('d M Y') : '-' }}</p>
                                <p><strong>Waktu:</strong>
                                    {{ $selectedTimeSlot ? $selectedTimeSlot . ' - ' . $this->getEndTime() : '-' }}</p>
                            </div>
                            <button type="submit" wire:loading.attr="disabled"
                                class="bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                                <span wire:loading.remove>Buat Booking</span>
                                <span wire:loading>Memproses...</span>
                            </button>
                        </div>
                    </div>
            </form>
        @endif

        <!-- User Bookings -->
        @if ($userBookings->count() > 0)
            <div class="mt-8 bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Booking Saya</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach ($userBookings as $booking)
                        <div class="p-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-gray-900">
                                        {{ $this->getFacilityDisplayName($booking->facility_type) }}</h4>
                                    <p class="text-sm text-gray-600">{{ $booking->notes ?? 'Tidak ada catatan' }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $booking->booking_date->format('d M Y') }},
                                        {{ $booking->start_time->format('H:i') }} -
                                        {{ $booking->end_time->format('H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $booking->status === 'active'
                                    ? 'bg-green-100 text-green-800'
                                    : ($booking->status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : 'bg-gray-100 text-gray-800') }}">
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
