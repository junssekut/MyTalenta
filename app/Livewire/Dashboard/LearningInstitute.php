<?php

namespace App\Livewire\Dashboard;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\Booking;
use App\Models\Report;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LearningInstitute extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        // Get today's attendance
        $todayAttendance = Attendance::where('user_id', $user->id)
            ->where('date', today())
            ->first();
            
        // Get recent bookings
        $recentBookings = Booking::where('user_id', $user->id)
            ->whereHas('room', function($query) {
                $query->where('type', 'discussion');
            })
            ->with('room')
            ->latest()
            ->take(3)
            ->get();
            
        // Get recent reports
        $recentReports = Report::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();
            
        // Get announcements for user's program
        $announcements = Announcement::where('is_published', true)
            ->where(function($query) use ($user) {
                $query->where('target_audience', 'all')
                      ->orWhere('target_audience', $user->batch?->program?->name);
            })
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('livewire.dashboard.learning-institute', [
            'todayAttendance' => $todayAttendance,
            'recentBookings' => $recentBookings,
            'recentReports' => $recentReports,
            'announcements' => $announcements,
        ]);
    }
}
