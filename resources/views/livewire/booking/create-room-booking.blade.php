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
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Peminjaman Ruangan Diskusi</h1>
                    <p class="text-blue-700 text-lg font-medium">Formulir pengajuan peminjaman ruangan untuk diskusi dan
                        belajar</p>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if (session()->has('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-8">
            <!-- Pilih Ruangan -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Pilih Ruangan</h2>
                        <p class="text-sm text-gray-600">Pilih ruangan yang tersedia untuk kegiatan Anda</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach ($rooms as $room)
                        <label class="relative cursor-pointer group">
                            <input type="radio" wire:model.live="room_id" value="{{ $room->id }}"
                                class="sr-only peer">
                            <div
                                class="border-2 rounded-xl p-6 transition-all duration-300 hover:shadow-lg
                                {{ $room_id == $room->id ? 'border-blue-500 bg-gradient-to-br from-blue-50 to-blue-100 shadow-lg' : 'border-gray-200 hover:border-blue-300 bg-white' }}">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center mb-2">
                                            <div
                                                class="w-8 h-8 rounded-lg {{ $room_id == $room->id ? 'bg-blue-500' : 'bg-gray-200' }} flex items-center justify-center mr-3">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <h3 class="font-bold text-gray-900 text-lg">{{ $room->name }}</h3>
                                        </div>
                                        <p class="text-sm text-gray-600 mb-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $room->location }}
                                        </p>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                            </svg>
                                            Kapasitas: {{ $room->capacity }} orang
                                        </div>
                                        @if ($room->description)
                                            <p class="text-xs text-gray-500 mt-2">{{ $room->description }}</p>
                                        @endif
                                    </div>
                                    @if ($room_id == $room->id)
                                        <div class="ml-4">
                                            <div
                                                class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('room_id')
                    <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-sm text-red-700">{{ $message }}</p>
                        </div>
                    </div>
                @enderror
            </div>

            <!-- Detail Peminjaman -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Detail Peminjaman</h2>
                        <p class="text-sm text-gray-600">Isi informasi lengkap untuk permintaan peminjaman</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Purpose -->
                    <div class="md:col-span-2">
                        <label for="purpose" class="block text-sm font-semibold text-gray-700 mb-3">
                            Tujuan Peminjaman *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <input type="text" wire:model="purpose" id="purpose"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                                placeholder="Contoh: Diskusi kelompok, Belajar bersama, dll">
                        </div>
                        @error('purpose')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md">
                                <p class="text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-semibold text-gray-700 mb-3">
                            Deskripsi Tambahan
                        </label>
                        <div class="relative">
                            <textarea wire:model="description" id="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 resize-none"
                                placeholder="Jelaskan lebih detail tentang kegiatan yang akan dilakukan..."></textarea>
                        </div>
                        @error('description')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md">
                                <p class="text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Participant Count -->
                    <div>
                        <label for="participant_count" class="block text-sm font-semibold text-gray-700 mb-3">
                            Jumlah Peserta *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <input type="number" wire:model.live="participant_count" id="participant_count"
                                min="1"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                        @error('participant_count')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md">
                                <p class="text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Booking Date -->
                    <div>
                        <label for="booking_date" class="block text-sm font-semibold text-gray-700 mb-3">
                            Tanggal Peminjaman *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3a4 4 0 118 0v4m-4 0H8m4 0h4.5a2.5 2.5 0 012.5 2.5v10a2.5 2.5 0 01-2.5 2.5h-13A2.5 2.5 0 013 19.5v-10A2.5 2.5 0 015.5 7H8" />
                                </svg>
                            </div>
                            <input type="date" wire:model="booking_date" id="booking_date"
                                min="{{ today()->format('Y-m-d') }}"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                        @error('booking_date')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md">
                                <p class="text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-sm font-semibold text-gray-700 mb-3">
                            Waktu Mulai *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="time" wire:model="start_time" id="start_time"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                        @error('start_time')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md">
                                <p class="text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-sm font-semibold text-gray-700 mb-3">
                            Waktu Selesai *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <input type="time" wire:model="end_time" id="end_time"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                        </div>
                        @error('end_time')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 rounded-md">
                                <p class="text-sm text-red-700">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Participants -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">Daftar Peserta</h2>
                        <p class="text-sm text-gray-600">Pilih mahasiswa yang akan mengikuti kegiatan</p>
                    </div>
                </div>

                <!-- Search Participants -->
                <div class="mb-6">
                    <label for="participant_search" class="block text-sm font-semibold text-gray-700 mb-3">
                        Cari Mahasiswa
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" wire:model.live="participant_search" id="participant_search"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200"
                            placeholder="Ketik nama mahasiswa untuk mencari...">
                    </div>
                    <p class="text-xs text-gray-500 mt-2">Ketik untuk mencari mahasiswa secara langsung</p>
                </div>

                <!-- Available Participants -->
                @if (count($available_participants) > 0)
                    <div class="mb-6">
                        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Hasil Pencarian
                        </h3>
                        <div class="max-h-64 overflow-y-auto border border-gray-200 rounded-lg bg-gray-50">
                            @foreach ($available_participants as $participant)
                                <div
                                    class="flex items-center justify-between p-4 border-b border-gray-100 last:border-b-0 hover:bg-white transition-colors duration-150">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                            <span
                                                class="text-white font-medium text-sm">{{ $participant->initials() }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $participant->name }}
                                            </p>
                                            <p class="text-xs text-gray-600">{{ $participant->email }}</p>
                                            @if ($participant->batch)
                                                <p class="text-xs text-blue-600 font-medium">
                                                    {{ $participant->batch->program->display_name ?? 'Program' }} -
                                                    {{ $participant->batch->display_name ?? $participant->batch->name }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" wire:click="addParticipant({{ $participant->id }})"
                                        class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Tambah
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Selected Participants -->
                @if ($selected_participants->count() > 0)
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Peserta Terpilih ({{ $selected_participants->count() }})
                        </h3>
                        <div class="space-y-3">
                            @foreach ($selected_participants as $participant)
                                <div
                                    class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                            <span
                                                class="text-white font-medium text-sm">{{ $participant->initials() }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $participant->name }}
                                            </p>
                                            <p class="text-xs text-gray-600">{{ $participant->email }}</p>
                                            @if ($participant->batch)
                                                <p class="text-xs text-blue-600 font-medium">
                                                    {{ $participant->batch->program->display_name ?? 'Program' }} -
                                                    {{ $participant->batch->display_name ?? $participant->batch->name }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" wire:click="removeParticipant({{ $participant->id }})"
                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Hapus
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Submit Section -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl shadow-lg border border-blue-200 p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Siap Mengajukan Peminjaman?</h3>
                        <p class="text-gray-600">Pastikan semua informasi telah diisi dengan benar sebelum mengirim
                            permintaan.</p>
                        @if ($selected_participants->count() > 0)
                            <div class="mt-3 flex items-center text-sm text-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $selected_participants->count() }} peserta telah dipilih
                            </div>
                        @endif
                    </div>
                    <div class="flex space-x-4">
                        <button type="button" onclick="window.history.back()"
                            class="inline-flex items-center px-6 py-3 border border-gray-300 text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Batal
                        </button>
                        <button type="submit"
                            class="inline-flex items-center px-8 py-3 border border-transparent text-sm font-bold rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            Ajukan Peminjaman
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
