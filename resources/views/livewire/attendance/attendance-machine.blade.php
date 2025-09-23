<div class="min-h-screen bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 flex items-center justify-center">
    <div class="max-w-md w-full mx-4">
        <!-- Main Card -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 text-center">
                <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-white mb-2">Mesin Absensi</h1>
                <p class="text-blue-100">BCA Learning Institute</p>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Current Time -->
                <div class="text-center mb-6">
                    <div class="text-3xl font-bold text-gray-800" id="current-time">
                        {{ now()->format('H:i:s') }}
                    </div>
                    <div class="text-gray-600">
                        {{ now()->format('l, d F Y') }}
                    </div>
                </div>

                <!-- Message Display -->
                @if($message)
                <div class="mb-6 p-4 rounded-lg 
                    {{ $message_type === 'success' ? 'bg-green-100 border border-green-400 text-green-700' : 
                       ($message_type === 'error' ? 'bg-red-100 border border-red-400 text-red-700' : 
                        'bg-blue-100 border border-blue-400 text-blue-700') }}">
                    <div class="flex items-center">
                        @if($message_type === 'success')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($message_type === 'error')
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        @endif
                        <span class="font-medium">{{ $message }}</span>
                    </div>
                </div>
                @endif

                <!-- User Info Display -->
                @if($user_info)
                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <h3 class="font-semibold text-gray-800 mb-2">Informasi Pengguna</h3>
                    <div class="space-y-1 text-sm text-gray-600">
                        <div><strong>Nama:</strong> {{ $user_info['name'] }}</div>
                        <div><strong>NIM:</strong> {{ $user_info['student_id'] }}</div>
                        <div><strong>Batch:</strong> {{ $user_info['batch'] }}</div>
                        @if($user_info['check_in'])
                            <div><strong>Jam Masuk:</strong> {{ $user_info['check_in'] }}</div>
                        @endif
                        @if($user_info['check_out'])
                            <div><strong>Jam Keluar:</strong> {{ $user_info['check_out'] }}</div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Card Input Form -->
                <form wire:submit="submitAttendance" class="space-y-4">
                    <div>
                        <label for="card_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Scan atau masukkan ID Kartu (12 digit)
                        </label>
                        <input 
                            type="text" 
                            id="card_id"
                            wire:model="card_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-lg font-mono"
                            placeholder="xxxxxxxxxxxx"
                            maxlength="12"
                            autofocus
                            autocomplete="off">
                        @error('card_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200">
                        Absen Sekarang
                    </button>
                </form>

                <!-- Info -->
                <div class="mt-6 text-center text-sm text-gray-500">
                    <p>Tempelkan kartu pada sensor atau masukkan ID kartu secara manual</p>
                </div>
            </div>
        </div>

        <!-- Back to Dashboard -->
        <div class="text-center mt-6">
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center text-white hover:text-blue-200 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"/>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Auto-clear message script -->
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('clear-message', () => {
                setTimeout(() => {
                    Livewire.dispatch('clearMessage');
                }, 5000);
            });
        });

        // Update time every second
        setInterval(function() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('id-ID', { 
                hour12: false,
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            const timeElement = document.getElementById('current-time');
            if (timeElement) {
                timeElement.textContent = timeString;
            }
        }, 1000);
    </script>
</div>
