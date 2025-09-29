<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\FacilityBooking;
use App\Models\ShuttleBooking;
use App\Models\User;
use App\Models\Room;
use App\Models\ShuttleRoute;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Bookings extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $filterType = 'all'; // all, room, facility, shuttle
    public $filterStatus = 'all'; // all, pending, approved, rejected, cancelled

    // Modal properties
    public $showDetailModal = false;
    public $selectedBooking = null;
    public $selectedBookingType = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'filterType' => ['except' => 'all'],
        'filterStatus' => ['except' => 'all'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterType()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function viewBooking($bookingId, $type)
    {
        $this->selectedBookingType = $type;

        switch ($type) {
            case 'room':
                $this->selectedBooking = Booking::with(['user', 'room', 'approver'])->findOrFail($bookingId);
                break;
            case 'facility':
                $this->selectedBooking = FacilityBooking::with(['user'])->findOrFail($bookingId);
                break;
            case 'shuttle':
                $this->selectedBooking = ShuttleBooking::with(['user', 'shuttleRoute'])->findOrFail($bookingId);
                break;
        }

        $this->showDetailModal = true;
    }

    public function approveBooking($bookingId, $type)
    {
        switch ($type) {
            case 'room':
                $booking = Booking::findOrFail($bookingId);
                $booking->update([
                    'status' => 'approved',
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);
                break;
            case 'facility':
                $booking = FacilityBooking::findOrFail($bookingId);
                $booking->update(['status' => 'approved']);
                break;
            case 'shuttle':
                $booking = ShuttleBooking::findOrFail($bookingId);
                $booking->update(['status' => 'approved']);
                break;
        }

        session()->flash('message', 'Booking approved successfully.');
        $this->closeModal();
    }

    public function rejectBooking($bookingId, $type)
    {
        switch ($type) {
            case 'room':
                $booking = Booking::findOrFail($bookingId);
                $booking->update([
                    'status' => 'rejected',
                    'approved_by' => Auth::id(),
                    'approved_at' => now(),
                ]);
                break;
            case 'facility':
                $booking = FacilityBooking::findOrFail($bookingId);
                $booking->update(['status' => 'rejected']);
                break;
            case 'shuttle':
                $booking = ShuttleBooking::findOrFail($bookingId);
                $booking->update(['status' => 'rejected']);
                break;
        }

        session()->flash('message', 'Booking rejected successfully.');
        $this->closeModal();
    }

    public function cancelBooking($bookingId, $type)
    {
        switch ($type) {
            case 'room':
                $booking = Booking::findOrFail($bookingId);
                $booking->update(['status' => 'cancelled']);
                break;
            case 'facility':
                $booking = FacilityBooking::findOrFail($bookingId);
                $booking->update(['status' => 'cancelled']);
                break;
            case 'shuttle':
                $booking = ShuttleBooking::findOrFail($bookingId);
                $booking->update(['status' => 'cancelled']);
                break;
        }

        session()->flash('message', 'Booking cancelled successfully.');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->selectedBooking = null;
        $this->selectedBookingType = null;
    }

    public function getBookings()
    {
        $roomBookings = collect();
        $facilityBookings = collect();
        $shuttleBookings = collect();

        // Get room bookings
        if ($this->filterType === 'all' || $this->filterType === 'room') {
            $roomQuery = Booking::with(['user', 'room', 'approver'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->whereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('room', function ($roomQuery) {
                            $roomQuery->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('purpose', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->filterStatus !== 'all', function ($query) {
                    $query->where('status', $this->filterStatus);
                });

            $roomBookings = $roomQuery->get()->map(function ($booking) {
                return (object) [
                    'id' => $booking->id,
                    'type' => 'room',
                    'type_label' => 'Room Booking',
                    'user_name' => $booking->user->name,
                    'user_email' => $booking->user->email,
                    'title' => $booking->purpose,
                    'details' => $booking->room->name . ' - ' . $booking->start_time->format('d/m/Y H:i') . ' - ' . $booking->end_time->format('H:i'),
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                    'start_time' => $booking->start_time,
                ];
            });
        }

        // Get facility bookings
        if ($this->filterType === 'all' || $this->filterType === 'facility') {
            $facilityQuery = FacilityBooking::with(['user'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->whereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('facility_type', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->filterStatus !== 'all', function ($query) {
                    $query->where('status', $this->filterStatus);
                });

            $facilityBookings = $facilityQuery->get()->map(function ($booking) {
                return (object) [
                    'id' => $booking->id,
                    'type' => 'facility',
                    'type_label' => 'Facility Booking',
                    'user_name' => $booking->user->name,
                    'user_email' => $booking->user->email,
                    'title' => ucfirst($booking->facility_type),
                    'details' => \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') . ' - ' . $booking->start_time . ' - ' . $booking->end_time,
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                    'start_time' => $booking->booking_date,
                ];
            });
        }

        // Get shuttle bookings
        if ($this->filterType === 'all' || $this->filterType === 'shuttle') {
            $shuttleQuery = ShuttleBooking::with(['user', 'shuttleRoute'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->whereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('email', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('shuttleRoute', function ($routeQuery) {
                            $routeQuery->where('name', 'like', '%' . $this->search . '%')
                                     ->orWhere('destination', 'like', '%' . $this->search . '%');
                        });
                    });
                })
                ->when($this->filterStatus !== 'all', function ($query) {
                    $query->where('status', $this->filterStatus);
                });

            $shuttleBookings = $shuttleQuery->get()->map(function ($booking) {
                return (object) [
                    'id' => $booking->id,
                    'type' => 'shuttle',
                    'type_label' => 'Shuttle Booking',
                    'user_name' => $booking->user->name,
                    'user_email' => $booking->user->email,
                    'title' => $booking->shuttleRoute->name . ' (' . ucfirst($booking->type) . ')',
                    'details' => \Carbon\Carbon::parse($booking->travel_date)->format('d/m/Y'),
                    'status' => $booking->status,
                    'created_at' => $booking->created_at,
                    'start_time' => $booking->travel_date,
                ];
            });
        }

        // Combine all bookings
        $allBookings = $roomBookings->concat($facilityBookings)->concat($shuttleBookings);

        // Sort combined bookings
        $allBookings = $allBookings->sortBy([[$this->sortField, $this->sortDirection === 'desc' ? 'desc' : 'asc']]);

        // Paginate
        $page = $this->getPage();
        $perPage = $this->perPage;
        $offset = ($page - 1) * $perPage;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $allBookings->slice($offset, $perPage)->values(),
            $allBookings->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'pageName' => 'page']
        );
    }

    public function render()
    {
        $bookings = $this->getBookings();

        return view('livewire.admin.bookings', compact('bookings'));
    }
}