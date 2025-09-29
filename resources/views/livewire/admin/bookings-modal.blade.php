<!-- Booking Detail Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="booking-modal">
    <div
        class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white max-h-[90vh] overflow-y-auto">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">
                    Detail Pemesanan - {{ ucfirst($selectedBookingType) }}
                </h3>
                <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-4 space-y-6">
                @if ($selectedBookingType === 'room')
                    <!-- Room Booking Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pemesan</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $selectedBooking->user->email }}</div>
                            @if ($selectedBooking->user->student_id)
                                <div class="text-sm text-gray-500">NIM: {{ $selectedBooking->user->student_id }}</div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ruangan</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->room->name }}</div>
                            <div class="text-sm text-gray-500">
                                {{ $selectedBooking->room->location ?? 'Lokasi tidak tersedia' }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->start_time->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Selesai</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->end_time->format('H:i') }}</div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Keperluan</label>
                        <div class="text-sm text-gray-900">{{ $selectedBooking->purpose }}</div>
                    </div>

                    @if ($selectedBooking->description)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->description }}</div>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Peserta</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->participant_count }} orang</div>
                        </div>

                        @if ($selectedBooking->participants)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Daftar Peserta</label>
                                <div class="text-sm text-gray-900">
                                    @foreach (json_decode($selectedBooking->participants, true) as $participant)
                                        <div>• {{ $participant['name'] }} ({{ $participant['email'] }})</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                @elseif($selectedBookingType === 'facility')
                    <!-- Facility Booking Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pemesan</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $selectedBooking->user->email }}</div>
                            @if ($selectedBooking->user->student_id)
                                <div class="text-sm text-gray-500">NIM: {{ $selectedBooking->user->student_id }}</div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fasilitas</label>
                            <div class="text-sm text-gray-900">{{ ucfirst($selectedBooking->facility_type) }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($selectedBooking->booking_date)->format('d/m/Y') }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Mulai</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->start_time }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Waktu Selesai</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->end_time }}</div>
                        </div>
                    </div>

                    @if ($selectedBooking->notes)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->notes }}</div>
                        </div>
                    @endif
                @elseif($selectedBookingType === 'shuttle')
                    <!-- Shuttle Booking Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pemesan</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $selectedBooking->user->email }}</div>
                            @if ($selectedBooking->user->student_id)
                                <div class="text-sm text-gray-500">NIM: {{ $selectedBooking->user->student_id }}</div>
                            @endif
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rute Shuttle</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->shuttleRoute->name }}</div>
                            <div class="text-sm text-gray-500">{{ $selectedBooking->shuttleRoute->destination }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Perjalanan</label>
                            <div class="text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($selectedBooking->travel_date)->format('d/m/Y') }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Perjalanan</label>
                            <div class="text-sm text-gray-900">{{ ucfirst($selectedBooking->type) }}</div>
                        </div>
                    </div>

                    @if ($selectedBooking->booking_deadline)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Batas Waktu Pemesanan</label>
                            <div class="text-sm text-gray-900">
                                {{ $selectedBooking->booking_deadline->format('d/m/Y H:i') }}</div>
                        </div>
                    @endif

                    @if ($selectedBooking->notes)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                            <div class="text-sm text-gray-900">{{ $selectedBooking->notes }}</div>
                        </div>
                    @endif
                @endif

                <!-- Status and Actions -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <span
                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if ($selectedBooking->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($selectedBooking->status === 'approved') bg-green-100 text-green-800
                                @elseif($selectedBooking->status === 'rejected') bg-red-100 text-red-800
                                @elseif($selectedBooking->status === 'cancelled') bg-gray-100 text-gray-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($selectedBooking->status) }}
                            </span>
                        </div>

                        <div class="flex space-x-2">
                            @if ($selectedBooking->status === 'pending')
                                <button
                                    wire:click="approveBooking({{ $selectedBooking->id }}, '{{ $selectedBookingType }}')"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Setujui
                                </button>
                                <button
                                    wire:click="rejectBooking({{ $selectedBooking->id }}, '{{ $selectedBookingType }}')"
                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Tolak
                                </button>
                            @endif
                            @if (in_array($selectedBooking->status, ['pending', 'approved']))
                                <button
                                    wire:click="cancelBooking({{ $selectedBooking->id }}, '{{ $selectedBookingType }}')"
                                    wire:confirm="Apakah Anda yakin ingin membatalkan pemesanan ini?"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Batalkan
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Timestamps -->
                <div class="border-t border-gray-200 pt-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-gray-500">
                        <div>
                            <span class="font-medium">Dibuat:</span>
                            {{ $selectedBooking->created_at->format('d/m/Y H:i') }}
                        </div>
                        @if ($selectedBooking->updated_at && $selectedBooking->updated_at != $selectedBooking->created_at)
                            <div>
                                <span class="font-medium">Diupdate:</span>
                                {{ $selectedBooking->updated_at->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        @if (isset($selectedBooking->approved_at) && $selectedBooking->approved_at)
                            <div>
                                <span class="font-medium">Disetujui:</span>
                                {{ $selectedBooking->approved_at->format('d/m/Y H:i') }}
                                @if (isset($selectedBooking->approver))
                                    <br><span class="text-gray-400">oleh {{ $selectedBooking->approver->name }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
