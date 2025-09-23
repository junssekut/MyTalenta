<?php

namespace App\Livewire\Booking;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Rule;

class CreateRoomBooking extends Component
{
    #[Rule('required|exists:rooms,id')]
    public $room_id = '';
    
    #[Rule('required|string|max:255')]
    public $purpose = '';
    
    #[Rule('nullable|string')]
    public $description = '';
    
    #[Rule('required|integer|min:1')]
    public $participant_count = 1;
    
    #[Rule('required|date|after_or_equal:today')]
    public $booking_date = '';
    
    #[Rule('required|date_format:H:i')]
    public $start_time = '';
    
    #[Rule('required|date_format:H:i|after:start_time')]
    public $end_time = '';
    
    public $participants = [];
    public $participant_search = '';
    public $available_participants = [];
    
    public $room_type = 'discussion'; // discussion or dormitory
    
    public function mount($type = 'discussion')
    {
        $this->room_type = $type;
        $this->booking_date = today()->format('Y-m-d');
    }
    
    public function updatedParticipantSearch()
    {
        if (strlen($this->participant_search) >= 2) {
            $this->available_participants = User::where('name', 'like', '%' . $this->participant_search . '%')
                ->where('id', '!=', Auth::id())
                ->limit(10)
                ->get();
        } else {
            $this->available_participants = [];
        }
    }
    
    public function addParticipant($userId)
    {
        $user = User::find($userId);
        if ($user && !in_array($userId, $this->participants)) {
            $this->participants[] = $userId;
            $this->participant_search = '';
            $this->available_participants = [];
        }
    }
    
    public function removeParticipant($userId)
    {
        $this->participants = array_filter($this->participants, fn($id) => $id != $userId);
    }
    
    public function submit()
    {
        $this->validate();
        
        $start_datetime = $this->booking_date . ' ' . $this->start_time;
        $end_datetime = $this->booking_date . ' ' . $this->end_time;
        
        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $this->room_id,
            'purpose' => $this->purpose,
            'description' => $this->description,
            'participant_count' => $this->participant_count,
            'participants' => $this->participants,
            'start_time' => $start_datetime,
            'end_time' => $end_datetime,
            'status' => 'pending',
        ]);
        
        session()->flash('success', 'Permintaan peminjaman ruangan berhasil diajukan!');
        $this->reset();
        $this->booking_date = today()->format('Y-m-d');
    }

    public function render()
    {
        $rooms = Room::where('type', $this->room_type)
            ->where('is_active', true)
            ->get();
            
        $selected_participants = User::whereIn('id', $this->participants)->get();

        return view('livewire.booking.create-room-booking', [
            'rooms' => $rooms,
            'selected_participants' => $selected_participants,
        ]);
    }
}
