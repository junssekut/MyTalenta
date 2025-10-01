<?php

namespace App\Livewire\Shuttle;

use App\Models\ShuttleBooking;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ShuttleBookingApproval extends Component
{
    use WithPagination;

    public $filterStatus = 'pending';
    public $filterProgram = '';
    public $selectedBooking = null;
    public $approvalNotes = '';
    public $showApprovalModal = false;

    protected $rules = [
        'approvalNotes' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'approvalNotes.max' => 'Catatan maksimal 500 karakter.',
    ];

    public function mount()
    {
        // Determine user's program scope
        $user = Auth::user();
        if ($user->role->name === 'pic_ppti') {
            $this->filterProgram = 'PPTI';
        } elseif ($user->role->name === 'pic_ppbp') {
            $this->filterProgram = 'PPBP';
        }
    }

    public function getBookingsProperty()
    {
        $query = ShuttleBooking::with(['user.program', 'user.batch', 'shuttleRoute'])
            ->where('approval_status', $this->filterStatus)
            ->orderBy('created_at', 'desc');

        // Filter by program scope
        if ($this->filterProgram) {
            $query->whereHas('user.program', function($q) {
                $q->where('name', $this->filterProgram);
            });
        }

        return $query->paginate(15);
    }

    public function getStatsProperty()
    {
        $query = ShuttleBooking::query();

        // Apply program filter
        if ($this->filterProgram) {
            $query->whereHas('user.program', function($q) {
                $q->where('name', $this->filterProgram);
            });
        }

        return [
            'pending' => (clone $query)->where('approval_status', 'pending')->count(),
            'approved' => (clone $query)->where('approval_status', 'approved')->count(),
            'rejected' => (clone $query)->where('approval_status', 'rejected')->count(),
        ];
    }

    public function openApprovalModal($bookingId)
    {
        $this->selectedBooking = ShuttleBooking::with(['user.program', 'user.batch', 'shuttleRoute'])
            ->find($bookingId);

        if ($this->selectedBooking) {
            $this->approvalNotes = '';
            $this->showApprovalModal = true;
        }
    }

    public function approveBooking()
    {
        $this->validate();

        if (!$this->selectedBooking) return;

        $this->selectedBooking->update([
            'approval_status' => 'approved',
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_notes' => $this->approvalNotes,
        ]);

        session()->flash('message', 'Pemesanan shuttle berhasil disetujui!');
        $this->closeModal();
    }

    public function rejectBooking()
    {
        $this->validate();

        if (!$this->selectedBooking) return;

        $this->selectedBooking->update([
            'approval_status' => 'rejected',
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'approval_notes' => $this->approvalNotes,
        ]);

        session()->flash('message', 'Pemesanan shuttle berhasil ditolak!');
        $this->closeModal();
    }

    public function closeModal()
    {
        $this->showApprovalModal = false;
        $this->selectedBooking = null;
        $this->approvalNotes = '';
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.shuttle.shuttle-booking-approval');
    }
}