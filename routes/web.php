<?php

use App\Livewire\Attendance\AttendanceMachine;
use App\Livewire\Booking\CreateRoomBooking;
use App\Livewire\Booking\DormitoryRoomBooking;
use App\Livewire\Booking\CreateFacilityBooking;
use App\Livewire\Dashboard\RumahTalenta;
use App\Livewire\Reports\CreateReport;
use App\Livewire\Shuttle\ShuttleBooking;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public attendance machine route
Route::get('/attendance', AttendanceMachine::class)->name('attendance.machine');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role.layout'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard modules
    Route::get('/rumah-talenta', RumahTalenta::class)
        ->name('rumah-talenta');
    
    // Booking routes
    Route::view('/booking/room', 'booking.room')
        ->name('booking.room');
    Route::view('/booking/dormitory-room', 'booking.dormitory-room')
        ->name('booking.dormitory-room');
    
    // Facility booking
    Route::view('/booking/facility', 'booking.facility')
        ->name('booking.facility');
    
    // Shuttle booking
    Route::view('/shuttle/booking', 'shuttle.booking')
        ->name('shuttle.booking');
    
    // Reports
    Route::view('/reports/create', 'reports.create')
        ->name('reports.create');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('users');
    Route::get('/bookings', \App\Livewire\Admin\Bookings::class)->name('bookings');
    Route::get('/reports', \App\Livewire\Admin\Reports::class)->name('reports');
    Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
