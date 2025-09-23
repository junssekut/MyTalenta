<?php

use App\Livewire\Attendance\AttendanceMachine;
use App\Livewire\Booking\CreateRoomBooking;
use App\Livewire\Booking\DormitoryRoomBooking;
use App\Livewire\Booking\CreateFacilityBooking;
use App\Livewire\Dashboard\LearningInstitute;
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
    Route::get('/learning-institute', LearningInstitute::class)
        ->name('learning-institute');
    Route::get('/rumah-talenta', RumahTalenta::class)
        ->name('rumah-talenta');
    
    // Booking routes
    Route::get('/booking/room', CreateRoomBooking::class)
        ->name('booking.room');
    Route::get('/booking/dormitory-room', DormitoryRoomBooking::class)
        ->name('booking.dormitory-room');
    
    // Facility booking
    Route::get('/booking/facility', CreateFacilityBooking::class)
        ->name('booking.facility');
    
    // Shuttle booking
    Route::get('/shuttle/booking', ShuttleBooking::class)
        ->name('shuttle.booking');
    
    // Reports
    Route::get('/reports/create', CreateReport::class)
        ->name('reports.create');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
