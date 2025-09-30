<?php

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new #[Layout('layouts.auth')] class extends Component {
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        redirect()->intended(route('dashboard'));
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
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

    <div class="relative w-full max-w-md z-10">
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

        <!-- Premium Login Card -->
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
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">Selamat Datang Kembali</h2>
                    <p class="text-gray-600 text-sm leading-relaxed">Masuk ke akun Anda untuk melanjutkan perjalanan</p>
                </div>

                <!-- Session Status -->
                @if (session('status'))
                    <div
                        class="mb-6 rounded-2xl bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200/50 p-4 shadow-sm">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="h-4 w-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-sm text-green-800 font-medium">{{ session('status') }}</p>
                        </div>
                    </div>
                @endif

                <form wire:submit="login" class="space-y-6">
                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-3">
                            Email Address
                        </label>
                        <div class="relative group">
                            <input wire:model="email" id="email" type="email" autofocus autocomplete="email"
                                placeholder="masukkan@email.com"
                                class="w-full pl-12 pr-4 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                    {{ $errors->has('email') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                    group-hover:shadow-md" />
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @error('email')
                            <p
                                class="mt-3 text-sm text-red-600 flex items-center bg-red-50 px-3 py-2 rounded-xl border border-red-100">
                                <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex justify-between items-center mb-3">
                            <label for="password" class="block text-sm font-semibold text-gray-700">
                                Password
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" wire:navigate
                                    class="text-sm text-blue-600 hover:text-blue-700 font-medium transition-all duration-200 hover:underline">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <div class="relative group">
                            <input wire:model="password" id="password" type="password" autocomplete="current-password"
                                placeholder="Masukkan password"
                                class="w-full pl-12 pr-12 py-4 border-2 rounded-2xl focus:ring-4 transition-all duration-300 bg-gray-50/70 focus:bg-white shadow-sm
                                    {{ $errors->has('password') ? 'border-red-300 focus:ring-red-100 focus:border-red-400' : 'border-gray-200 focus:ring-blue-100 focus:border-blue-400' }}
                                    group-hover:shadow-md" />
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <div class="w-6 h-6 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                <button type="button" onclick="togglePassword()"
                                    class="w-6 h-6 bg-gray-100 hover:bg-gray-200 rounded-lg flex items-center justify-center transition-colors duration-200 group">
                                    <svg id="eye-icon" class="h-4 w-4 text-gray-600 group-hover:text-gray-800"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        @error('password')
                            <p
                                class="mt-3 text-sm text-red-600 flex items-center bg-red-50 px-3 py-2 rounded-xl border border-red-100">
                                <svg class="h-4 w-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center">
                            <input wire:model="remember" id="remember" type="checkbox"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded transition-all duration-200 checked:bg-blue-600" />
                            <label for="remember" class="ml-3 block text-sm text-gray-700 font-medium cursor-pointer">
                                Ingat saya
                            </label>
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
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Masuk ke Akun
                        </span>
                        <span wire:loading class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Memproses...
                        </span>
                    </button>
                </form>

                @if (Route::has('register'))
                    <div class="mt-8 text-center">
                        <p class="text-gray-600 text-sm">
                            Belum memiliki akun?
                            <a href="{{ route('register') }}" wire:navigate
                                class="font-semibold text-blue-600 hover:text-blue-700 transition-all duration-200 hover:underline ml-1">
                                Daftar sekarang
                            </a>
                        </p>
                    </div>
                @endif
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

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eye-icon');

        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21" />';
        } else {
            input.type = 'password';
            icon.innerHTML =
                '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }
</script>
