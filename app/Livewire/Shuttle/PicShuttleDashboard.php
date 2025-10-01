<?php

namespace App\Livewire\Shuttle;

use App\Models\ShuttleBooking;
use App\Models\ShuttleRoute;
use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class PicShuttleDashboard extends Component
{
    use WithPagination;

    // Route Management
    public $showRouteForm = false;
    public $editingRoute = null;
    public $routeForm = [
        'name' => '',
        'destination' => '',
        'description' => '',
        'departure_time' => '',
        'capacity' => 50,
        'is_active' => true,
    ];

    // Settings Management
    public $bookingDeadlineDay = 'wednesday';
    public $bookingDeadlineTime = '17:00';

    // Filters
    public $filterPeriod = 'today';
    public $filterRoute = '';
    public $filterStatus = '';

    protected $rules = [
        'routeForm.name' => 'required|string|max:255',
        'routeForm.destination' => 'required|string|max:255',
        'routeForm.description' => 'nullable|string|max:500',
        'routeForm.departure_time' => 'required|date_format:H:i',
        'routeForm.capacity' => 'required|integer|min:1|max:100',
        'routeForm.is_active' => 'boolean',
    ];

    protected $messages = [
        'routeForm.name.required' => 'Nama rute wajib diisi.',
        'routeForm.destination.required' => 'Tujuan rute wajib diisi.',
        'routeForm.departure_time.required' => 'Waktu keberangkatan wajib diisi.',
        'routeForm.capacity.required' => 'Kapasitas wajib diisi.',
        'routeForm.capacity.min' => 'Kapasitas minimal 1 orang.',
        'routeForm.capacity.max' => 'Kapasitas maksimal 100 orang.',
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->bookingDeadlineDay = SystemSetting::get('shuttle_friday_deadline_day', 'wednesday');
        $this->bookingDeadlineTime = SystemSetting::get('shuttle_friday_deadline_time', '17:00');
    }

    public function saveSettings()
    {
        SystemSetting::updateOrCreate(
            ['key' => 'shuttle_friday_deadline_day'],
            [
                'value' => $this->bookingDeadlineDay,
                'type' => 'string',
                'description' => 'Hari batas booking shuttle Jumat',
                'category' => 'shuttle'
            ]
        );

        SystemSetting::updateOrCreate(
            ['key' => 'shuttle_friday_deadline_time'],
            [
                'value' => $this->bookingDeadlineTime,
                'type' => 'string',
                'description' => 'Jam batas booking shuttle Jumat',
                'category' => 'shuttle'
            ]
        );

        session()->flash('message', 'Pengaturan berhasil disimpan!');
    }

    public function createRoute()
    {
        $this->resetRouteForm();
        $this->showRouteForm = true;
        $this->editingRoute = null;
    }

    public function editRoute($routeId)
    {
        $route = ShuttleRoute::find($routeId);
        if ($route) {
            $this->routeForm = [
                'name' => $route->name,
                'destination' => $route->destination,
                'description' => $route->description,
                'departure_time' => $route->departure_time ? $route->departure_time->format('H:i') : '',
                'capacity' => $route->capacity,
                'is_active' => $route->is_active,
            ];
            $this->showRouteForm = true;
            $this->editingRoute = $route;
        }
    }

    public function saveRoute()
    {
        $this->validate();

        if ($this->editingRoute) {
            $this->editingRoute->update($this->routeForm);
            session()->flash('message', 'Rute shuttle berhasil diperbarui!');
        } else {
            ShuttleRoute::create($this->routeForm);
            session()->flash('message', 'Rute shuttle berhasil ditambahkan!');
        }

        $this->resetRouteForm();
        $this->showRouteForm = false;
        $this->editingRoute = null;
    }

    public function deleteRoute($routeId)
    {
        $route = ShuttleRoute::find($routeId);
        if ($route) {
            // Check if route has active bookings
            $activeBookings = $route->shuttleBookings()
                ->where('travel_date', '>=', now()->toDateString())
                ->where('status', 'confirmed')
                ->count();

            if ($activeBookings > 0) {
                session()->flash('error', 'Tidak dapat menghapus rute yang masih memiliki pemesanan aktif.');
                return;
            }

            $route->delete();
            session()->flash('message', 'Rute shuttle berhasil dihapus!');
        }
    }

    public function toggleRouteStatus($routeId)
    {
        $route = ShuttleRoute::find($routeId);
        if ($route) {
            $route->update(['is_active' => !$route->is_active]);
            session()->flash('message', 'Status rute berhasil diperbarui!');
        }
    }

    public function cancelRouteForm()
    {
        $this->resetRouteForm();
        $this->showRouteForm = false;
        $this->editingRoute = null;
    }

    private function resetRouteForm()
    {
        $this->routeForm = [
            'name' => '',
            'destination' => '',
            'description' => '',
            'departure_time' => '',
            'capacity' => 50,
            'is_active' => true,
        ];
    }

    public function getRoutesProperty()
    {
        return ShuttleRoute::orderBy('destination')->get();
    }

    public function getBookingsProperty()
    {
        $query = ShuttleBooking::with(['user', 'shuttleRoute', 'approver'])
            ->orderBy('travel_date', 'desc')
            ->orderBy('created_at', 'desc');

        // Apply filters
        switch ($this->filterPeriod) {
            case 'today':
                $query->whereDate('travel_date', today());
                break;
            case 'week':
                $query->whereBetween('travel_date', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('travel_date', now()->month)
                      ->whereYear('travel_date', now()->year);
                break;
        }

        if ($this->filterRoute) {
            $query->where('shuttle_route_id', $this->filterRoute);
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        return $query->paginate(15);
    }

    public function getBookingStatsProperty()
    {
        $query = ShuttleBooking::query();

        // Apply period filter
        switch ($this->filterPeriod) {
            case 'today':
                $query->whereDate('travel_date', today());
                break;
            case 'week':
                $query->whereBetween('travel_date', [now()->startOfWeek(), now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('travel_date', now()->month)
                      ->whereYear('travel_date', now()->year);
                break;
        }

        return [
            'total' => $query->count(),
            'confirmed' => (clone $query)->where('status', 'confirmed')->count(),
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
        ];
    }

    public function getRouteStatsProperty()
    {
        $routes = ShuttleRoute::with(['shuttleBookings' => function($query) {
            switch ($this->filterPeriod) {
                case 'today':
                    $query->whereDate('travel_date', today());
                    break;
                case 'week':
                    $query->whereBetween('travel_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('travel_date', now()->month)
                          ->whereYear('travel_date', now()->year);
                    break;
            }
        }])->get();

        return $routes->map(function($route) {
            return [
                'id' => $route->id,
                'name' => $route->name,
                'destination' => $route->destination,
                'total_bookings' => $route->shuttleBookings->count(),
                'confirmed_bookings' => $route->shuttleBookings->where('status', 'confirmed')->count(),
            ];
        });
    }

    public function render()
    {
        return view('livewire.shuttle.pic-shuttle-dashboard');
    }
}