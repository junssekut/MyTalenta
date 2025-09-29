<!-- Report Detail Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="report-modal">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Detail Laporan</h3>
                <button wire:click="$set('showDetailModal', false)" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="mt-4">
                @if ($selectedReport)
                    <!-- Report Type Badge -->
                    <div class="mb-4">
                        <span
                            class="inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            @if ($selectedReport->type === 'user_report') bg-blue-100 text-blue-800
                            @elseif($selectedReport->type === 'violation') bg-red-100 text-red-800
                            @elseif($selectedReport->type === 'attendance') bg-green-100 text-green-800
                            @elseif($selectedReport->type === 'lecturer_attendance') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $selectedReport->type_label }}
                        </span>
                    </div>

                    <!-- Report Details -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Judul</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedReport->title }}</p>
                        </div>

                        @if ($selectedReport->description)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedReport->description }}</p>
                            </div>
                        @endif

                        @if ($selectedReport->user_name)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Pihak Terkait</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedReport->user_name }}</p>
                            </div>
                        @endif

                        @if ($selectedReport->location)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $selectedReport->location }}</p>
                            </div>
                        @endif

                        @if ($selectedReport->priority)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prioritas</label>
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                    @if ($selectedReport->priority === 'low') bg-gray-100 text-gray-800
                                    @elseif($selectedReport->priority === 'medium') bg-yellow-100 text-yellow-800
                                    @elseif($selectedReport->priority === 'high') bg-red-100 text-red-800
                                    @elseif($selectedReport->priority === 'critical') bg-red-100 text-red-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($selectedReport->priority) }}
                                </span>
                            </div>
                        @endif

                        <!-- Status and Dates -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span
                                    class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1
                                    @if ($selectedReport->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($selectedReport->status === 'approved') bg-green-100 text-green-800
                                    @elseif($selectedReport->status === 'resolved') bg-green-100 text-green-800
                                    @elseif($selectedReport->status === 'rejected') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($selectedReport->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dibuat</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $selectedReport->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        @if ($selectedReport->updated_at && $selectedReport->updated_at != $selectedReport->created_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Terakhir Diubah</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    {{ $selectedReport->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        @endif

                        <!-- Additional Details based on type -->
                        @if ($selectedReport->type === 'attendance' || $selectedReport->type === 'lecturer_attendance')
                            <div class="border-t pt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Detail Absensi</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    @if ($selectedReport->check_in_time)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $selectedReport->check_in_time }}
                                            </p>
                                        </div>
                                    @endif
                                    @if ($selectedReport->check_out_time)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Jam Keluar</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $selectedReport->check_out_time }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($selectedReport->type === 'user_report' && $selectedReport->photos && count($selectedReport->photos) > 0)
                            <div class="border-t pt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Foto</h4>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach ($selectedReport->photos as $photo)
                                        <img src="{{ asset('storage/' . $photo) }}" alt="Report Photo"
                                            class="w-full h-24 object-cover rounded-lg cursor-pointer"
                                            onclick="window.open('{{ asset('storage/' . $photo) }}', '_blank')">
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200 mt-6">
                        @if ($selectedReport->status === 'pending')
                            <button wire:click="updateStatus('approved')"
                                class="px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Setujui
                            </button>
                            <button wire:click="updateStatus('rejected')"
                                class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Tolak
                            </button>
                        @elseif($selectedReport->status === 'approved')
                            <button wire:click="updateStatus('resolved')"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Tandai Selesai
                            </button>
                        @endif

                        <button wire:click="$set('showDetailModal', false)"
                            class="px-4 py-2 bg-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Tutup
                        </button>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Data laporan tidak ditemukan.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
