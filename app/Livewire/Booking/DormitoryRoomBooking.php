<?php

namespace App\Livewire\Booking;

use Livewire\Component;
use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DormitoryRoomBooking extends Component
{
    public $roomId;
    public $bookingDate;
    public $participantCount = 1;
    public $selectedTimeSlot;
    public $purpose;
    
    public $availableRooms;
    public $availableTimeSlots = [];
    public $userBookings;

    protected $rules = [
        'roomId' => 'required|exists:rooms,id',
        'bookingDate' => 'required|date|after_or_equal:today',
        'participantCount' => 'required|integer|min:1',
        'selectedTimeSlot' => 'required',
        'purpose' => 'required|string|min:10|max:500',
    ];

    protected $messages = [
        'roomId.required' => 'Silakan pilih ruangan.',
        'bookingDate.required' => 'Tanggal peminjaman harus diisi.',
        'bookingDate.after_or_equal' => 'Tanggal peminjaman tidak boleh kurang dari hari ini.',
        'participantCount.required' => 'Jumlah peserta harus diisi.',
        'participantCount.min' => 'Jumlah peserta minimal 1 orang.',
        'selectedTimeSlot.required' => 'Silakan pilih slot waktu.',
        'purpose.required' => 'Alasan peminjaman harus diisi.',
        'purpose.min' => 'Alasan peminjaman minimal 10 karakter.',
        'purpose.max' => 'Alasan peminjaman maksimal 500 karakter.',
    ];

    public function mount()
    {
        $this->loadAvailableRooms();
        $this->loadUserBookings();
        $this->bookingDate = date('Y-m-d');
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['roomId', 'bookingDate'])) {
            $this->generateTimeSlots();
        }

        if ($propertyName === 'participantCount' && $this->roomId) {
            $room = Room::find($this->roomId);
            if ($room && $this->participantCount > $room->capacity) {
                $this->addError('participantCount', "Jumlah peserta tidak boleh melebihi kapasitas ruangan ({$room->capacity} orang).");
            }
        }
    }

    public function loadAvailableRooms()
    {
        $this->availableRooms = Room::where('type', 'dormitory')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();
    }

    public function loadUserBookings()
    {
        $this->userBookings = Booking::with('room')
            ->where('user_id', Auth::id())
            ->where('type', 'dormitory_room')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function generateTimeSlots()
    {
        if (!$this->roomId || !$this->bookingDate) {
            $this->availableTimeSlots = [];
            return;
        }

        $date = Carbon::parse($this->bookingDate);
        $slots = [];
        
        // Generate slots from 08:00 to 22:00 (2-hour intervals)
        for ($hour = 8; $hour <= 20; $hour += 2) {
            $startTime = $date->copy()->setTime($hour, 0);
            $endTime = $startTime->copy()->addHours(2);
            
            // Check if slot is available (no existing bookings)
            $isAvailable = !Booking::where('room_id', $this->roomId)
                ->where('type', 'dormitory_room')
                ->where('status', '!=', 'rejected')
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('start_time', [$startTime, $endTime->subMinute()])
                        ->orWhereBetween('end_time', [$startTime->addMinute(), $endTime])
                        ->orWhere(function($q) use ($startTime, $endTime) {
                            $q->where('start_time', '<=', $startTime)
                              ->where('end_time', '>=', $endTime);
                        });
                })
                ->exists();

            $slots[] = [
                'start' => $startTime->format('H:i'),
                'end' => $endTime->format('H:i'),
                'available' => $isAvailable,
            ];
        }

        $this->availableTimeSlots = $slots;
    }

    public function submit()
    {
        $this->validate();

        // Additional validation for room capacity
        $room = Room::find($this->roomId);
        if ($this->participantCount > $room->capacity) {
            $this->addError('participantCount', "Jumlah peserta tidak boleh melebihi kapasitas ruangan ({$room->capacity} orang).");
            return;
        }

        // Parse the selected time slot
        $bookingDate = Carbon::parse($this->bookingDate);
        $startTime = $bookingDate->copy()->setTimeFromTimeString($this->selectedTimeSlot);
        $endTime = $startTime->copy()->addHours(2);

        // Double-check availability
        $conflictingBooking = Booking::where('room_id', $this->roomId)
            ->where('type', 'dormitory_room')
            ->where('status', '!=', 'rejected')
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime->subMinute()])
                    ->orWhereBetween('end_time', [$startTime->addMinute(), $endTime])
                    ->orWhere(function($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<=', $startTime)
                          ->where('end_time', '>=', $endTime);
                    });
            })
            ->exists();

        if ($conflictingBooking) {
            $this->addError('selectedTimeSlot', 'Slot waktu yang dipilih sudah tidak tersedia. Silakan refresh halaman dan pilih slot lain.');
            return;
        }

        // Create the booking
        Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $this->roomId,
            'type' => 'dormitory_room',
            'purpose' => $this->purpose,
            'participant_count' => $this->participantCount,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
        ]);

        // Reset form
        $this->reset(['roomId', 'participantCount', 'selectedTimeSlot', 'purpose']);
        $this->bookingDate = date('Y-m-d');
        $this->availableTimeSlots = [];

        // Reload data
        $this->loadUserBookings();

        session()->flash('message', 'Peminjaman ruangan berhasil diajukan! Silakan tunggu konfirmasi dari Core Team PIC ruangan.');
        
        return redirect()->route('dashboard')->with('success', 'Peminjaman ruangan berhasil diajukan! Silakan tunggu konfirmasi dari Core Team PIC ruangan.');
    }

    public function render()
    {
        return view('livewire.booking.dormitory-room-booking')
            ->layout('layouts.app');
    }
}
