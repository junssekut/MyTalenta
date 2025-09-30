<?php

use App\Models\Batch;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $student_id = '';
    public string $card_id = '';
    public ?int $batch_id = null;
    public string $phone = '';
    public string $address = '';
    public string $gender = '';
    public string $date_of_birth = '';
    public string $emergency_contact_name = '';
    public string $emergency_contact_phone = '';

    public $batches;

    public function mount()
    {
        $this->batches = Batch::with('program')->get();
    }

    public function saveProfile()
    {
        $validated = $this->validate([
            'student_id' => ['required', 'string', 'unique:users,student_id,' . Auth::id()],
            'card_id' => ['required', 'string', 'size:12', 'unique:users,card_id,' . Auth::id()],
            'batch_id' => ['required', 'exists:batches,id'],
            'phone' => ['required', 'string', 'regex:/^(\+62|62|0)[8-9][0-9]{7,11}$/'],
            'address' => ['required', 'string', 'max:500'],
            'gender' => ['required', 'in:male,female'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'emergency_contact_name' => ['required', 'string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'regex:/^(\+62|62|0)[8-9][0-9]{7,11}$/'],
        ]);

        $user = Auth::user();
        $user->update(array_merge($validated, ['profile_completed' => true]));

        return redirect()->route('dashboard');
    }
}; ?>

<div
    class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-blue-100 flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background Elements -->
    <div class="absolute inset-0">
        <!-- Floating geometric shapes -->
        <div class="absolute top-20 left-10 w-32 h-32 bg-blue-200/20 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-indigo-300/20 rounded-full blur-lg animate-pulse delay-1000">
        </div>
        <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-blue-300/15 rounded-full blur-2xl animate-pulse delay-500">
        </div>
        <div
            class="absolute bottom-20 right-10 w-28 h-28 bg-indigo-200/20 rounded-full blur-xl animate-pulse delay-1500">
        </div>

        <!-- Subtle pattern overlay -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="80" height="80" viewBox="0 0 80 80"
            xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%230066AE"
            fill-opacity="0.02"%3E%3Ccircle cx="40" cy="40" r="1.5" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')]
            opacity-60"></div>
    </div>

    <div class="relative w-full max-w-2xl z-10">
        <!-- Enhanced Logo and Header -->
        <div class="text-center mb-10">
            <!-- Animated logo container -->
            <div class="relative inline-block mb-6">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-3xl blur-lg opacity-50 animate-pulse">
                </div>
                <div
                    class="relative w-20 h-20 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-3xl shadow-2xl flex items-center justify-center transform hover:scale-105 transition-all duration-300">
                    <span class="text-3xl font-black text-white tracking-wider">MT</span>
                    <!-- Shine effect -->
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent rounded-3xl transform -skew-x-12 animate-pulse">
                    </div>
                </div>
            </div>

            <h1 class="text-4xl font-bold text-gray-900 mb-3 tracking-tight">MyTalenta</h1>
            <p class="text-gray-600 text-sm font-medium leading-relaxed max-w-xs mx-auto">
                Sistem Manajemen Terpadu Mahasiswa Beasiswa BCA
            </p>
        </div>

        <!-- Premium Profile Setup Card -->
        <div
            class="bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/30 p-8 relative overflow-hidden">
            <!-- Card background pattern -->
            <div
                class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-50/50 to-indigo-50/50 rounded-full -translate-y-16 translate-x-16">
            </div>
            <div
                class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-indigo-50/50 to-blue-50/50 rounded-full translate-y-12 -translate-x-12">
            </div>

            <div class="relative z-10">
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Lengkapi Profil Anda</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">Mohon lengkapi data pribadi Anda untuk melanjutkan
                    </p>
                </div>

                <form wire:submit="saveProfile" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student ID -->
                        <div>
                            <label for="student_id" class="block text-sm font-semibold text-gray-700 mb-3">
                                NIM
                            </label>
                            <div class="relative group">
                                <input wire:model="student_id" id="student_id" type="text" autofocus
                                    autocomplete="off" placeholder="Masukkan NIM"
                                    class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                        {{ $errors->has('student_id') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                        group-hover:shadow-md" />
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('student_id')
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Card ID -->
                        <div>
                            <label for="card_id" class="block text-sm font-semibold text-gray-700 mb-3">
                                ID Kartu (12 digit)
                            </label>
                            <div class="relative group">
                                <input wire:model="card_id" id="card_id" type="text" autocomplete="off"
                                    placeholder="Masukkan ID Kartu"
                                    class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                        {{ $errors->has('card_id') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                        group-hover:shadow-md" />
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <div class="w-6 h-6 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('card_id')
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Batch -->
                        <div>
                            <label for="batch_id" class="block text-sm font-semibold text-gray-700 mb-3">
                                Program & Batch
                            </label>
                            <div class="relative group">
                                <select wire:model="batch_id" id="batch_id"
                                    class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                        {{ $errors->has('batch_id') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                        group-hover:shadow-md">
                                    <option value="">Pilih Program & Batch</option>
                                    @foreach ($batches as $batch)
                                        <option value="{{ $batch->id }}">{{ $batch->program->name }} -
                                            {{ $batch->display_name }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('batch_id')
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nomor Telepon
                            </label>
                            <div class="relative group">
                                <input wire:model="phone" id="phone" type="tel" autocomplete="tel"
                                    placeholder="081234567890"
                                    class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                        {{ $errors->has('phone') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                        group-hover:shadow-md" />
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('phone')
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-semibold text-gray-700 mb-3">
                                Jenis Kelamin
                            </label>
                            <div class="relative group">
                                <select wire:model="gender" id="gender"
                                    class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                        {{ $errors->has('gender') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                        group-hover:shadow-md">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <div class="w-6 h-6 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('gender')
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date of Birth -->
                        <div>
                            <label for="date_of_birth" class="block text-sm font-semibold text-gray-700 mb-3">
                                Tanggal Lahir
                            </label>
                            <div class="relative group">
                                <input wire:model="date_of_birth" id="date_of_birth" type="date"
                                    class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                        {{ $errors->has('date_of_birth') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                        group-hover:shadow-md" />
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('date_of_birth')
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-3">
                            Alamat Lengkap
                        </label>
                        <div class="relative group">
                            <textarea wire:model="address" id="address" rows="3" placeholder="Masukkan alamat lengkap Anda"
                                class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                    {{ $errors->has('address') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                    group-hover:shadow-md"></textarea>
                            <div class="absolute top-4 left-0 pl-4 flex items-start pointer-events-none">
                                <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @error('address')
                            <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Emergency Contact Name -->
                        <div>
                            <label for="emergency_contact_name"
                                class="block text-sm font-semibold text-gray-700 mb-3">
                                Nama Kontak Darurat
                            </label>
                            <div class="relative group">
                                <input wire:model="emergency_contact_name" id="emergency_contact_name" type="text"
                                    autocomplete="name" placeholder="Nama orang yang bisa dihubungi"
                                    class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                        {{ $errors->has('emergency_contact_name') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                        group-hover:shadow-md" />
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('emergency_contact_name')
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Emergency Contact Phone -->
                        <div>
                            <label for="emergency_contact_phone"
                                class="block text-sm font-semibold text-gray-700 mb-3">
                                Telepon Kontak Darurat
                            </label>
                            <div class="relative group">
                                <input wire:model="emergency_contact_phone" id="emergency_contact_phone"
                                    type="tel" autocomplete="tel" placeholder="081234567890"
                                    class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                        {{ $errors->has('emergency_contact_phone') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                        group-hover:shadow-md" />
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @error('emergency_contact_phone')
                                <p class="mt-3 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="cursor-pointer w-full flex justify-center py-4 px-6 border border-transparent rounded-2xl shadow-xl text-sm font-semibold text-white bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-700 hover:from-blue-700 hover:via-blue-800 hover:to-indigo-800 focus:outline-none focus:ring-4 focus:ring-blue-200 transform hover:scale-[1.02] hover:shadow-2xl transition-all duration-300 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-lg group"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove class="flex items-center">
                            <svg class="w-5 h-5 mr-3 group-hover:animate-bounce" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Simpan Profil
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Enhanced Footer -->
        <div class="text-center mt-8">
            <p class="text-gray-500 text-xs font-medium">
                © {{ date('Y') }} PT Bank Central Asia Tbk. All rights reserved.
            </p>
            <div class="flex justify-center items-center mt-2 space-x-1">
                <div class="w-1 h-1 bg-blue-400 rounded-full animate-pulse"></div>
                <div class="w-1 h-1 bg-blue-500 rounded-full animate-pulse delay-75"></div>
                <div class="w-1 h-1 bg-blue-600 rounded-full animate-pulse delay-150"></div>
            </div>
        </div>
    </div>
</div>
