<?php

namespace App\Livewire\Booking;

use Livewire\Component;
use App\Models\FacilityBooking;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreateFacilityBooking extends Component
{
    public $facilityType;
    public $bookingDate;
    public $selectedTimeSlot;
    public $duration = 2; // Default 2 hours for washing machine
    public $notes;
    
    public $maxWashingMachineMale = 2;
    public $maxWashingMachineFemale = 2;
    public $maxKitchenUsers = 4;
    public $minDate;
    public $availableTimeSlots = [];
    public $userBookings;

    protected $rules = [
        'facilityType' => 'required|in:washing_machine_male,washing_machine_female,kitchen',
        'bookingDate' => 'required|date|after:today',
        'selectedTimeSlot' => 'required',
        'duration' => 'required|integer|min:1|max:4',
        'notes' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'facilityType.required' => 'Silakan pilih jenis fasilitas.',
        'bookingDate.required' => 'Tanggal booking harus diisi.',
        'bookingDate.after' => 'Booking minimal H+1 dari hari ini.',
        'selectedTimeSlot.required' => 'Silakan pilih slot waktu.',
        'duration.required' => 'Durasi penggunaan harus diisi.',
        'duration.min' => 'Durasi minimal 1 jam.',
        'duration.max' => 'Durasi maksimal 4 jam.',
    ];

    public function mount()
    {
        $this->minDate = Carbon::tomorrow()->format('Y-m-d');
        $this->loadSystemSettings();
        $this->loadUserBookings();
    }

    public function updated($propertyName)
    {
        if (in_array($propertyName, ['facilityType', 'bookingDate', 'duration'])) {
            $this->generateTimeSlots();
        }
    }

    public function loadSystemSettings()
    {
        $settings = SystemSetting::pluck('value', 'key');
        
        $this->maxWashingMachineMale = $settings['max_washing_machine_male'] ?? 2;
        $this->maxWashingMachineFemale = $settings['max_washing_machine_female'] ?? 2;
        $this->maxKitchenUsers = $settings['max_kitchen_users'] ?? 4;
    }

    public function loadUserBookings()
    {
        $this->userBookings = FacilityBooking::where('user_id', Auth::id())
            ->where('booking_date', '>=', Carbon::today())
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->limit(10)
            ->get();
    }

    public function generateTimeSlots()
    {
        if (!$this->facilityType || !$this->bookingDate) {
            $this->availableTimeSlots = [];
            return;
        }

        $date = Carbon::parse($this->bookingDate);
        $slots = [];
        $maxSlots = $this->getMaxSlots();
        $duration = $this->facilityType === 'kitchen' ? ($this->duration ?? 1) : 2;
        
        // Generate slots from 06:00 to 22:00
        for ($hour = 6; $hour <= 22; $hour++) {
            $startTime = $date->copy()->setTime($hour, 0);
            $endTime = $startTime->copy()->addHours($duration);
            
            // Skip if end time exceeds 23:59
            if ($endTime->hour >= 24) {
                continue;
            }
            
            // Count existing bookings for this slot
            $existingBookings = FacilityBooking::where('facility_type', $this->facilityType)
                ->where('booking_date', $date->toDateString())
                ->where('status', '!=', 'cancelled')
                ->where(function($query) use ($startTime, $endTime) {
                    $query->where(function($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $endTime->format('H:i:s'))
                          ->where('end_time', '>', $startTime->format('H:i:s'));
                    });
                })
                ->count();

            $availableCount = $maxSlots - $existingBookings;
            
            $slots[] = [
                'start' => $startTime->format('H:i'),
                'end' => $endTime->format('H:i'),
                'available' => $availableCount > 0,
                'available_count' => $availableCount,
            ];
        }

        $this->availableTimeSlots = $slots;
    }

    public function getMaxSlots()
    {
        switch ($this->facilityType) {
            case 'washing_machine_male':
                return $this->maxWashingMachineMale;
            case 'washing_machine_female':
                return $this->maxWashingMachineFemale;
            case 'kitchen':
                return $this->maxKitchenUsers;
            default:
                return 1;
        }
    }

    public function getFacilityName()
    {
        $names = [
            'washing_machine_male' => 'Mesin Cuci Pria',
            'washing_machine_female' => 'Mesin Cuci Wanita',
            'kitchen' => 'Dapur Bersama',
        ];
        
        return $names[$this->facilityType] ?? '';
    }

    public function getFacilityDisplayName($type)
    {
        $names = [
            'washing_machine_male' => 'Mesin Cuci Pria',
            'washing_machine_female' => 'Mesin Cuci Wanita',
            'kitchen' => 'Dapur Bersama',
        ];
        
        return $names[$type] ?? $type;
    }

    public function getEndTime()
    {
        if (!$this->selectedTimeSlot) return '';
        
        $duration = $this->facilityType === 'kitchen' ? ($this->duration ?? 1) : 2;
        $endTime = Carbon::createFromTimeString($this->selectedTimeSlot)->addHours($duration);
        
        return $endTime->format('H:i');
    }

    public function submit()
    {
        $this->validate();

        // Parse times
        $bookingDate = Carbon::parse($this->bookingDate);
        $startTime = Carbon::createFromTimeString($this->selectedTimeSlot);
        $duration = $this->facilityType === 'kitchen' ? $this->duration : 2;
        $endTime = $startTime->copy()->addHours($duration);

        // Check availability again
        $maxSlots = $this->getMaxSlots();
        $existingBookings = FacilityBooking::where('facility_type', $this->facilityType)
            ->where('booking_date', $bookingDate->toDateString())
            ->where('status', '!=', 'cancelled')
            ->where(function($query) use ($startTime, $endTime) {
                $query->where(function($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<', $endTime->format('H:i:s'))
                      ->where('end_time', '>', $startTime->format('H:i:s'));
                });
            })
            ->count();

        if ($existingBookings >= $maxSlots) {
            $this->addError('selectedTimeSlot', 'Slot waktu yang dipilih sudah penuh. Silakan pilih slot lain.');
            return;
        }

        // Create booking
        FacilityBooking::create([
            'user_id' => Auth::id(),
            'facility_type' => $this->facilityType,
            'booking_date' => $bookingDate->toDateString(),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'duration_hours' => $duration,
            'notes' => $this->notes,
            'status' => 'active',
        ]);

        // Reset form
        $this->reset(['selectedTimeSlot', 'notes']);
        if ($this->facilityType === 'kitchen') {
            $this->duration = 1;
        }

        // Reload data
        $this->loadUserBookings();
        $this->generateTimeSlots();

        session()->flash('message', 'Booking fasilitas berhasil dibuat!');
        
        return redirect()->route('dashboard')->with('success', 'Booking fasilitas berhasil dibuat!');
    }

    public function render()
    {
        return view('livewire.booking.facility-booking')
            ->layout('layouts.app');
    }
}
