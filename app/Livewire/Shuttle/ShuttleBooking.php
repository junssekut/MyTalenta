<?php

namespace App\Livewire\Shuttle;

use App\Models\ShuttleBooking as SB;
use App\Models\ShuttleRoute;
use App\Models\SystemSetting;
use Livewire\Component;
use Carbon\Carbon;

class ShuttleBooking extends Component
{
    public $shuttleType = '';
    public $selectedRoute = null;
    public $bookingDate = '';
    public $notes = '';
    public $isSubmitting = false;
    public $bookingClosed = false;
    public $userBookings;
    public $availableRoutes;

    public function mount()
    {
        $this->checkBookingClosed();
        $this->loadUserBookings();
        $this->updateAvailableRoutes();
    }

    public function checkBookingClosed()
    {
        $now = Carbon::now();
        $this->bookingClosed = $this->isBookingClosedForDate($now->toDateString());
    }

    protected $rules = [
        'shuttleType' => 'required|in:pulang,kembali',
        'selectedRoute' => 'required|exists:shuttle_routes,id',
        'bookingDate' => 'required|date|after:yesterday',
        'notes' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'shuttleType.required' => 'Jenis shuttle wajib dipilih.',
        'selectedRoute.required' => 'Rute shuttle wajib dipilih.',
        'bookingDate.required' => 'Tanggal pemesanan wajib diisi.',
        'bookingDate.after' => 'Tanggal pemesanan harus hari ini atau setelahnya.',
        'notes.max' => 'Catatan maksimal 500 karakter.',
    ];

    public function updatedBookingDate()
    {
        $this->validateOnly('bookingDate');
    }

    public function getBookingDeadlineInfoProperty()
    {
        $deadlineDay = SystemSetting::get('shuttle_friday_deadline_day', 'wednesday');
        $deadlineTime = SystemSetting::get('shuttle_friday_deadline_time', '17:00');

        return "Pemesanan shuttle untuk hari Jumat ditutup pada hari " . ucfirst($deadlineDay) . " jam {$deadlineTime}.";
    }

    public function isDateAvailable($date)
    {
        if (!$date) return false;

        $bookingDate = Carbon::parse($date);

        // Can't book for past dates
        if ($bookingDate->isPast() && !$bookingDate->isToday()) {
            return false;
        }

        // Check if booking is closed for this date
        return !$this->isBookingClosedForDate($date);
    }

    public function submit()
    {
        $this->validate();

        // Additional validation for booking closure
        if ($this->isBookingClosedForDate($this->bookingDate)) {
            $this->addError('bookingDate', 'Pemesanan shuttle untuk tanggal ini telah ditutup.');
            return;
        }

        // Check if user already has a booking for this date and type
        $existingBooking = SB::where('user_id', auth()->id())
            ->where('type', $this->shuttleType)
            ->whereDate('travel_date', $this->bookingDate)
            ->whereIn('status', ['pending', 'confirmed'])
            ->whereIn('approval_status', ['pending', 'approved'])
            ->first();

        if ($existingBooking) {
            $this->addError('bookingDate', 'Anda sudah memiliki pemesanan shuttle untuk tanggal dan jenis yang sama.');
            return;
        }

        $this->isSubmitting = true;

        try {

            SB::create([
                'user_id' => auth()->id(),
                'shuttle_route_id' => $this->selectedRoute,
                'travel_date' => $this->bookingDate,
                'type' => $this->shuttleType,
                'notes' => $this->notes,
                'status' => 'pending',
                'approval_status' => 'pending',
            ]);

            $this->reset(['shuttleType', 'selectedRoute', 'bookingDate', 'notes']);
            session()->flash('message', 'Pemesanan shuttle berhasil dibuat!');
            $this->loadUserBookings();

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat membuat pemesanan. Silakan coba lagi.');
        } finally {
            $this->isSubmitting = false;
        }
    }

    private function updateAvailableRoutes()
    {
        if (!$this->shuttleType) {
            $this->availableRoutes = collect();
            return;
        }

        $this->availableRoutes = ShuttleRoute::where('shuttle_type', $this->shuttleType)
            ->where('is_active', true)
            ->orderBy('destination')
            ->get();
    }

    private function isBookingClosedForDate($date)
    {
        $bookingDate = Carbon::parse($date);
        $deadlineDay = SystemSetting::get('shuttle_friday_deadline_day', 'wednesday');
        $deadlineTime = SystemSetting::get('shuttle_friday_deadline_time', '17:00');

        // If booking for Friday, check if current time is past Wednesday 17:00
        if ($bookingDate->isFriday()) {
            // Find the Wednesday of the current week for Friday booking
            $wednesday = $bookingDate->copy()->startOfWeek(Carbon::MONDAY)->addDays(2)->setTimeFromTimeString($deadlineTime);
            return Carbon::now()->isAfter($wednesday);
        }

        // For other days, bookings are generally open (could be extended for other rules)
        return false;
    }

    public function loadUserBookings()
    {
        $this->userBookings = SB::where('user_id', auth()->id())
            ->with(['shuttleRoute', 'approver'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.shuttle.shuttle-booking');
    }
}
