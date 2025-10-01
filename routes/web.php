<?php

use App\Livewire\Attendance\AttendanceMachine;
use App\Livewire\Booking\CreateRoomBooking;
use App\Livewire\Booking\DormitoryRoomBooking;
use App\Livewire\Booking\CreateFacilityBooking;
use App\Livewire\Dashboard\RumahTalenta;
use App\Livewire\Reports\CreateFacilityReport;
use App\Livewire\Shuttle\CreateShuttleBooking;
use App\Livewire\Shuttle\PicShuttleDashboard;
use App\Livewire\Shuttle\ShuttleBookingApproval;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public attendance machine route
Route::get('/attendance', AttendanceMachine::class)->name('attendance.machine');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'role.layout', 'profile.completed'])
    ->name('dashboard');

Volt::route('profile/setup', 'auth.profile-setup')
    ->middleware(['auth', 'verified'])
    ->name('profile.setup');

Route::middleware(['auth', 'verified', 'profile.completed'])->group(function () {
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
    Route::get('/shuttle/booking', CreateShuttleBooking::class)
        ->middleware(['role.layout'])
        ->name('shuttle.booking');
    
    // PIC Shuttle Dashboard
    Route::get('/shuttle/pic-dashboard', PicShuttleDashboard::class)
        ->middleware(['role:pic_shuttle'])
        ->name('shuttle.pic-dashboard');
    
    // Shuttle Booking Approval (PIC PPTI/PPBP)
    Route::get('/shuttle/approval', ShuttleBookingApproval::class)
        ->middleware(['role:pic_ppti,pic_ppbp'])
        ->name('shuttle.approval');    // Reports
    Route::view('/reports/create', 'reports.create')
        ->name('reports.create');
    Route::get('/reports/facility', CreateFacilityReport::class)
        ->name('reports.facility');
});

// Admin routes
Route::middleware(['auth', 'verified', 'role:admin', 'profile.completed'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', \App\Livewire\Admin\Users::class)->name('users');
    Route::get('/bookings', \App\Livewire\Admin\Bookings::class)->name('bookings');
    Route::get('/reports', \App\Livewire\Admin\Reports::class)->name('reports');
    Route::get('/settings', \App\Livewire\Admin\Settings::class)->name('settings');
});

Route::middleware(['auth', 'profile.completed'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
