<?php

namespace App\Livewire\Dashboard;

use App\Models\Booking;
use App\Models\Report;
use App\Models\SystemSetting;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class RumahTalenta extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        // Get Kios Talenta status
        $kiosTalentaStatus = SystemSetting::get('kios_talenta_status', 'closed');
        
        // Get recent dormitory room bookings
        $recentBookings = Booking::where('user_id', $user->id)
            ->whereHas('room', function($query) {
                $query->where('type', 'dormitory');
            })
            ->with('room')
            ->latest()
            ->take(3)
            ->get();
            
        // Get recent facility reports
        $recentReports = Report::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        return view('livewire.dashboard.rumah-talenta', [
            'kiosTalentaStatus' => $kiosTalentaStatus,
            'recentBookings' => $recentBookings,
            'recentReports' => $recentReports,
        ]);
    }
}
