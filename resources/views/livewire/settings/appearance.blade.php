<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<x-mytalenta-settings-layout>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Page Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div
                        class="w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Appearance</h1>
                        <p class="text-gray-600 dark:text-gray-400 mt-1">Update the appearance settings for your account
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

        <!-- Appearance Settings -->
        <div
            class="bg-white/90 dark:bg-gray-800/90 backdrop-blur-2xl rounded-3xl shadow-2xl border border-white/30 dark:border-gray-700/30 p-8">
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Theme Preference</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Choose how MyTalenta looks to you. Select a theme
                        or let your system decide.</p>

                    <!-- Theme Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Light Theme -->
                        <div class="relative">
                            <input type="radio" id="light" name="theme" value="light" class="sr-only peer"
                                checked>
                            <label for="light"
                                class="block p-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:border-blue-300 dark:hover:border-blue-600 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-yellow-400 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">Light</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Always use light theme
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Dark Theme -->
                        <div class="relative">
                            <input type="radio" id="dark" name="theme" value="dark" class="sr-only peer">
                            <label for="dark"
                                class="block p-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:border-blue-300 dark:hover:border-blue-600 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition duration-200">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gray-800 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">Dark</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Always use dark theme
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- System Theme -->
                        <div class="relative">
                            <input type="radio" id="system" name="theme" value="system" class="sr-only peer">
                            <label for="system"
                                class="block p-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl cursor-pointer hover:border-blue-300 dark:hover:border-blue-600 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 transition duration-200">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-gray-800 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">System</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Match system preference
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-mytalenta-settings-layout>
