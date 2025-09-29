<?php

namespace App\Livewire\Shuttle;

use App\Models\ShuttleBooking;
use App\Models\ShuttleRoute;
use Livewire\Component;
use Carbon\Carbon;

class CreateShuttleBooking extends Component
{
    public $shuttleType = '';
    public $selectedRoute = null;
    public $bookingDate = '';
    public $notes = '';
    public $isSubmitting = false;
    public $bookingClosed = false;
    public $userBookings;

    public function mount()
    {
        $this->checkBookingClosed();
        $this->loadUserBookings();
    }

    public function checkBookingClosed()
    {
        // Booking is closed if today is Wednesday after 17:00 for Friday bookings
        $now = Carbon::now();

        // If it's Friday, check if booking deadline has passed (Wednesday 17:00)
        if ($now->isFriday()) {
            $wednesday = Carbon::parse('last wednesday');
            $deadline = $wednesday->setTime(17, 0, 0);
            $this->bookingClosed = $now->isAfter($deadline);
        } else {
            $this->bookingClosed = false;
        }
    }

    protected $rules = [
        'shuttleType' => 'required|in:pulang,kembali',
        'selectedRoute' => 'required|exists:shuttle_routes,id',
        'bookingDate' => 'required|date|after:today',
        'notes' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'shuttleType.required' => 'Jenis shuttle wajib dipilih.',
        'selectedRoute.required' => 'Rute shuttle wajib dipilih.',
        'bookingDate.required' => 'Tanggal pemesanan wajib diisi.',
        'bookingDate.after' => 'Tanggal pemesanan harus setelah hari ini.',
        'notes.max' => 'Catatan maksimal 500 karakter.',
    ];

    public function updatedShuttleType()
    {
        $this->selectedRoute = null;
        $this->resetValidation('selectedRoute');
    }

    public function submit()
    {
        $this->validate();

        $this->isSubmitting = true;

        try {
            // Check if booking is closed for this date
            if ($this->isBookingClosed($this->bookingDate)) {
                session()->flash('error', 'Pemesanan shuttle untuk tanggal ini telah ditutup.');
                return;
            }

            // Check if user already has a booking for this date and type
            $existingBooking = ShuttleBooking::where('user_id', auth()->id())
                ->where('type', $this->shuttleType)
                ->whereDate('travel_date', $this->bookingDate)
                ->where('status', '!=', 'cancelled')
                ->first();

            if ($existingBooking) {
                session()->flash('error', 'Anda sudah memiliki pemesanan shuttle untuk tanggal dan jenis yang sama.');
                return;
            }

            // Create the booking
            ShuttleBooking::create([
                'user_id' => auth()->id(),
                'shuttle_route_id' => $this->selectedRoute,
                'travel_date' => $this->bookingDate,
                'type' => $this->shuttleType,
                'notes' => $this->notes,
                'status' => 'confirmed',
            ]);

            // Reset form
            $this->reset(['shuttleType', 'selectedRoute', 'bookingDate', 'notes']);

            session()->flash('message', 'Pemesanan shuttle berhasil dibuat!');

            // Reload user bookings
            $this->loadUserBookings();

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat membuat pemesanan. Silakan coba lagi.');
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function getAvailableRoutesProperty()
    {
        return ShuttleRoute::where('is_active', true)
            ->orderBy('destination')
            ->get();
    }

    public function getBookingClosedProperty()
    {
        // Booking is closed if today is Wednesday after 17:00 for Friday bookings
        $now = Carbon::now();

        // If it's Friday, check if booking deadline has passed (Wednesday 17:00)
        if ($now->isFriday()) {
            $wednesday = Carbon::parse('last wednesday');
            $deadline = $wednesday->setTime(17, 0, 0);
            return $now->isAfter($deadline);
        }

        return false;
    }

    private function isBookingClosed($date)
    {
        $bookingDate = Carbon::parse($date);

        // If booking for Friday, check Wednesday 17:00 deadline
        if ($bookingDate->isFriday()) {
            $deadline = Carbon::parse('this wednesday 17:00');
            return Carbon::now()->isAfter($deadline);
        }

        return false;
    }

    public function loadUserBookings()
    {
        $this->userBookings = ShuttleBooking::where('user_id', auth()->id())
            ->with('shuttleRoute')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.shuttle.shuttle-booking');
    }
}
