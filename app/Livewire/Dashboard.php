<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Booking;
use App\Models\Attendance;
use App\Models\LecturerAttendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $activeBookings = 0;
    public $attendanceRate = 95;
    public $upcomingEvents = 0;
    public $notifications = 0;
    public $recentActivity;
    public $announcements;
    public $todaySchedule;
    public $greeting;
    public $motivationalQuote;

    public function mount()
    {
        // Set greeting based on current time
        $this->greeting = now()->format('H') < 12
            ? 'Pagi'
            : (now()->format('H') < 15
                ? 'Siang'
                : (now()->format('H') < 18
                    ? 'Sore'
                    : 'Malam'));
        
        // Set motivational quote
        $motivationalQuotes = [
            'Hari ini adalah kesempatan baru untuk menjadi lebih baik!',
            'Setiap langkah kecil adalah progress yang berharga.',
            'Tetap semangat, kamu pasti bisa!',
            'Kesuksesan dimulai dari konsistensi setiap hari.',
            'Percayai prosesmu, hasil akan mengikuti.',
        ];
        $this->motivationalQuote = $motivationalQuotes[array_rand($motivationalQuotes)];
        
        // Initialize collections
        $this->recentActivity = collect([]);
        $this->announcements = collect([]);
        $this->todaySchedule = collect([]);
        
        $this->loadDashboardData();
    }

    public function loadDashboardData()
    {
        $user = Auth::user();
        
        if (!$user) {
            return;
        }

        // Active Bookings - count pending/approved bookings for current user
        $this->activeBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where('start_time', '>=', now())
            ->count();

        // Attendance Rate - calculate based on recent attendance records
        $this->calculateAttendanceRate();

        // Upcoming Events - count upcoming bookings
        $this->upcomingEvents = Booking::where('user_id', $user->id)
            ->where('start_time', '>=', now())
            ->where('start_time', '<=', now()->addDays(7))
            ->count();

        // Notifications - count unread announcements or pending approvals
        $this->notifications = $this->calculateNotifications();

        // Recent Activity - recent bookings and attendance
        $this->loadRecentActivity();

        // Announcements - recent announcements
        $this->loadAnnouncements();

        // Today's Schedule - today's bookings and classes
        $this->loadTodaySchedule();
    }

    private function calculateAttendanceRate()
    {
        $user = Auth::user();
        
        if (!$user) {
            $this->attendanceRate = 0;
            return;
        }
        
        $currentMonth = now()->month;
        $currentYear = now()->year;

        // Count total possible attendance days (weekdays in current month)
        $startOfMonth = Carbon::create($currentYear, $currentMonth, 1);
        $endOfMonth = $startOfMonth->copy()->endOfMonth();

        $totalWeekdays = 0;
        $currentDate = $startOfMonth->copy();

        while ($currentDate <= $endOfMonth) {
            if ($currentDate->isWeekday()) {
                $totalWeekdays++;
            }
            $currentDate->addDay();
        }

        // Count actual attendance records
        $actualAttendance = Attendance::where('user_id', $user->id)
            ->whereYear('date', $currentYear)
            ->whereMonth('date', $currentMonth)
            ->where('status', 'present')
            ->count();

        // Calculate rate
        $this->attendanceRate = $totalWeekdays > 0 ? round(($actualAttendance / $totalWeekdays) * 100) : 0;
    }

    private function calculateNotifications()
    {
        $user = Auth::user();
        $notifications = 0;
        
        if (!$user) {
            return 0;
        }

        // Count pending booking approvals
        $notifications += Booking::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        // Add other notification types as needed
        return $notifications;
    }

    private function loadRecentActivity()
    {
        $user = Auth::user();
        
        $this->recentActivity = collect([]);
        
        if (!$user) {
            return;
        }

        // Recent bookings
        $recentBookings = Booking::where('user_id', $user->id)
            ->with('room')
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($booking) {
                return [
                    'type' => 'booking',
                    'title' => 'Booking ' . $booking->room->name,
                    'description' => 'Status: ' . ucfirst($booking->status),
                    'time' => $booking->created_at->diffForHumans(),
                    'icon' => 'booking'
                ];
            });

        // Recent attendance
        $recentAttendance = Attendance::where('user_id', $user->id)
            ->latest()
            ->take(2)
            ->get()
            ->map(function ($attendance) {
                return [
                    'type' => 'attendance',
                    'title' => 'Absensi ' . $attendance->date->format('d/m'),
                    'description' => 'Status: ' . ucfirst($attendance->status),
                    'time' => $attendance->created_at->diffForHumans(),
                    'icon' => 'attendance'
                ];
            });

        $this->recentActivity = $recentBookings->concat($recentAttendance)
            ->sortByDesc('time')
            ->take(5);
    }

    private function loadAnnouncements()
    {
        try {
            // Load recent announcements if model exists
            if (class_exists('\App\Models\Announcement')) {
                $this->announcements = \App\Models\Announcement::latest()
                    ->take(3)
                    ->get();
            } else {
                $this->announcements = collect([]);
            }
        } catch (\Exception $e) {
            $this->announcements = collect([]);
        }
    }

    private function loadTodaySchedule()
    {
        $user = Auth::user();
        
        if (!$user) {
            $this->todaySchedule = collect([]);
            return;
        }
        
        $today = now()->toDateString();

        $this->todaySchedule = collect([]);

        // Today's bookings
        $todayBookings = Booking::where('user_id', $user->id)
            ->whereDate('start_time', $today)
            ->with('room')
            ->get()
            ->map(function ($booking) {
                return [
                    'title' => 'Booking ' . $booking->room->name,
                    'time' => Carbon::parse($booking->start_time)->format('H:i') . ' - ' . Carbon::parse($booking->end_time)->format('H:i'),
                    'type' => 'booking',
                    'color' => 'blue'
                ];
            });

        // Add sample class schedule (you can replace this with actual class schedule data)
        $sampleClasses = collect([
            [
                'title' => 'Kuliah Pemrograman',
                'time' => '08:00 - 10:00',
                'type' => 'class',
                'color' => 'blue'
            ],
            [
                'title' => 'Study Group',
                'time' => '14:00 - 16:00',
                'type' => 'class',
                'color' => 'green'
            ]
        ]);

        $this->todaySchedule = $todayBookings->concat($sampleClasses)
            ->sortBy(function ($item) {
                return substr($item['time'], 0, 5); // Sort by start time
            });
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}