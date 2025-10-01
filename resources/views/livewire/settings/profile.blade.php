<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new class extends Component {
    use WithFileUploads;
    public string $name = '';
    public string $email = '';
    public $profilePicture;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Update the profile picture for the currently authenticated user.
     */
    public function updateProfilePicture(): void
    {
        $this->validate([
            'profilePicture' => ['nullable', 'image', 'max:2048'], // 2MB max
        ]);

        $user = Auth::user();

        if ($this->profilePicture) {
            // Delete old profile picture if exists
            if ($user->profile_picture) {
                \Storage::disk('public')->delete($user->profile_picture);
            }

            // Store new profile picture
            $path = $this->profilePicture->store('profile-pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }

        $this->dispatch('profile-picture-updated');
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<x-mytalenta-settings-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Manage your account information and preferences
                        </p>
                    </div>
                </div>

                <!-- Settings Navigation -->
                <div class="flex items-center space-x-2">
                    <a href="{{ route('settings.profile') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('settings.profile') ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        Profile
                    </a>
                    <a href="{{ route('settings.password') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('settings.password') ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        Password
                    </a>
                    <a href="{{ route('settings.appearance') }}"
                        class="px-4 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('settings.appearance') ? 'bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white' }}">
                        Appearance
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Picture Card -->
            <div class="lg:col-span-1">
                <div class="bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/30 p-6">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Profile Picture</h3>

                        <!-- Current Profile Picture -->
                        <div class="relative inline-block mb-6">
                            @if (auth()->user()->profile_picture_url)
                                <div class="relative">
                                    <img src="{{ auth()->user()->profile_picture_url }}" alt="Profile Picture"
                                        class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-2xl">
                                    <div
                                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full border-4 border-white flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                </div>
                            @else
                                <div class="relative inline-block">
                                    <div
                                        class="w-32 h-32 rounded-full bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 flex items-center justify-center border-4 border-white shadow-2xl">
                                        <span
                                            class="text-4xl font-black text-white">{{ auth()->user()->initials() }}</span>
                                    </div>
                                    <div
                                        class="absolute -bottom-2 -right-2 w-8 h-8 bg-blue-500 rounded-full border-4 border-white flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Upload Form -->
                        <form wire:submit="updateProfilePicture" class="space-y-4">
                            <div>
                                <input wire:model="profilePicture" type="file" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400 text-center">
                                    JPG, PNG or GIF (max 2MB)
                                </p>
                            </div>

                            <button type="submit"
                                class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-4 rounded-xl shadow-lg transition duration-200 flex items-center justify-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <span>Upload Picture</span>
                            </button>

                            <div x-data="{ show: false }" x-show="show" x-transition class="text-center">
                                <div
                                    class="flex items-center justify-center space-x-2 text-green-600 dark:text-green-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Picture updated successfully!</span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Information Card -->
            <div class="lg:col-span-2">
                <div class="bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/30 p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">Personal Information</h3>
                            <p class="text-gray-600 text-sm">Update your account details</p>
                        </div>
                    </div>

                    <form wire:submit="updateProfileInformation" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full
                                    Name</label>
                                <input wire:model="name" type="text" required autofocus autocomplete="name"
                                    placeholder="Enter your full name"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition duration-200">
                            </div>

                            <!-- Email -->
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email
                                    Address</label>
                                <input wire:model="email" type="email" required autocomplete="email"
                                    placeholder="Enter your email address"
                                    class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 transition duration-200">

                                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                    <div
                                        class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl">
                                        <div class="flex items-start space-x-3">
                                            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                                                </path>
                                            </svg>
                                            <div class="flex-1">
                                                <p class="text-amber-800 dark:text-amber-200 font-medium">Your email
                                                    address is unverified.</p>
                                                <button wire:click.prevent="resendVerificationNotification"
                                                    class="text-sm text-amber-700 dark:text-amber-300 hover:text-amber-800 dark:hover:text-amber-100 cursor-pointer mt-2 inline-block font-medium">
                                                    Click here to re-send the verification email.
                                                </button>
                                            </div>
                                        </div>

                                        @if (session('status') === 'verification-link-sent')
                                            <div
                                                class="mt-4 p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                                <p class="text-green-800 dark:text-green-200 font-medium text-sm">
                                                    A new verification link has been sent to your email address.
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-4">
                                <div x-data="{ show: false }" x-show="show" x-transition
                                    class="flex items-center space-x-2 text-green-600 dark:text-green-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Profile updated successfully!</span>
                                </div>

                                <button type="submit"
                                    class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-8 rounded-xl shadow-lg transition duration-200 flex items-center space-x-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span>Save Changes</span>
                                </button>
                            </div>
                        </div>
                    </form>

                    @if (session('status') === 'verification-link-sent')
                        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <flux:text class="text-green-800 font-medium text-sm">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end pt-6 border-t border-gray-200">
            <div class="flex items-center space-x-4">
                <x-action-message on="profile-updated">
                    <div class="flex items-center space-x-2 text-green-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium">Profile updated successfully!</span>
                    </div>
                </x-action-message>

                <flux:button variant="primary" type="submit" class="px-8">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    Save Changes
                </flux:button>
            </div>
        </div>
        </form>
    </div>
    </div>
    </div>

    <!-- Account Management -->
    <div class="mt-8">
        <div class="bg-white/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/30 p-8">
            <div class="flex items-center space-x-3 mb-6">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-red-600 to-red-700 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Account Management</h3>
                    <p class="text-gray-600 text-sm">Danger zone - irreversible actions</p>
                </div>
            </div>

            <livewire:settings.delete-user-form />
        </div>
    </div>
    </div>
</x-mytalenta-settings-layout>
