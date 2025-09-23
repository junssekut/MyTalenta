<?php

namespace App\Livewire\Attendance;

use App\Models\Attendance;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Rule;

class AttendanceMachine extends Component
{
    #[Rule('required|string|size:12')]
    public $card_id = '';
    
    public $message = '';
    public $message_type = ''; // success, error, info
    public $user_info = null;
    
    public function submitAttendance()
    {
        $this->validate();
        
        // Find user by card_id
        $user = User::where('card_id', $this->card_id)->first();
        
        if (!$user) {
            $this->message = 'Kartu tidak terdaftar!';
            $this->message_type = 'error';
            $this->reset('card_id');
            return;
        }
        
        if (!$user->is_active) {
            $this->message = 'Akun tidak aktif!';
            $this->message_type = 'error';
            $this->reset('card_id');
            return;
        }
        
        $today = today();
        $now = now();
        
        // Get or create today's attendance
        $attendance = Attendance::firstOrCreate(
            [
                'user_id' => $user->id,
                'date' => $today,
            ],
            [
                'status' => 'present',
            ]
        );
        
        // Determine if this is check-in or check-out
        if (!$attendance->check_in_time) {
            // First scan of the day - check in
            $attendance->update([
                'check_in_time' => $now->format('H:i'),
            ]);
            $this->message = "Selamat pagi, {$user->name}! Absen masuk berhasil pada {$now->format('H:i')}";
            $this->message_type = 'success';
        } else {
            // Subsequent scans - update check out time
            $attendance->update([
                'check_out_time' => $now->format('H:i'),
            ]);
            $this->message = "Selamat sore, {$user->name}! Absen keluar berhasil pada {$now->format('H:i')}";
            $this->message_type = 'success';
        }
        
        $this->user_info = [
            'name' => $user->name,
            'student_id' => $user->student_id,
            'batch' => $user->batch?->display_name,
            'check_in' => $attendance->check_in_time,
            'check_out' => $attendance->check_out_time,
        ];
        
        $this->reset('card_id');
        
        // Auto clear message after 5 seconds
        $this->dispatch('clear-message');
    }
    
    public function clearMessage()
    {
        $this->reset('message', 'message_type', 'user_info');
    }

    public function render()
    {
        return view('livewire.attendance.attendance-machine');
    }
}
