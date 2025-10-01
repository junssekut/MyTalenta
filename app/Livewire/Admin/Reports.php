<?php

namespace App\Livewire\Admin;

use App\Models\Report;
use App\Models\ViolationRecord;
use App\Models\Attendance;
use App\Models\LecturerAttendance;
use App\Models\Booking;
use App\Models\FacilityBooking;
use App\Models\ShuttleBooking;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Reports extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Report type filters
    public $reportType = 'all'; // all, user_reports, violations, attendance, lecturer_attendance, bookings
    public $statusFilter = 'all';
    public $dateFrom = '';
    public $dateTo = '';
    public $priorityFilter = 'all';

    // Modal properties
    public $showDetailModal = false;
    public $selectedReport = null;
    public $selectedReportType = null;

    // Statistics
    public $stats = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'reportType' => ['except' => 'all'],
        'statusFilter' => ['except' => 'all'],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'priorityFilter' => ['except' => 'all'],
    ];

    public function mount()
    {
        $this->loadStats();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedReportType()
    {
        $this->resetPage();
        $this->loadStats();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedDateFrom()
    {
        $this->resetPage();
    }

    public function updatedDateTo()
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

    public function viewReport($reportId, $type)
    {
        $this->selectedReportType = $type;

        switch ($type) {
            case 'user_report':
                $this->selectedReport = Report::with(['user', 'assignedTo'])->findOrFail($reportId);
                break;
            case 'violation':
                $this->selectedReport = ViolationRecord::with(['user', 'recorder'])->findOrFail($reportId);
                break;
            case 'attendance':
                $this->selectedReport = Attendance::with(['user', 'reporter'])->findOrFail($reportId);
                break;
            case 'lecturer_attendance':
                $this->selectedReport = LecturerAttendance::with(['batch.program', 'reporter'])->findOrFail($reportId);
                break;
        }

        $this->showDetailModal = true;
    }

    public function updateReportStatus($reportId, $status)
    {
        $report = Report::findOrFail($reportId);
        $report->update(['status' => $status]);

        if ($status === 'resolved') {
            $report->update(['responded_at' => now()]);
        }

        session()->flash('message', 'Report status updated successfully.');
        $this->closeModal();
        $this->loadStats();
    }

    public function updateViolationStatus($violationId, $isResolved)
    {
        $violation = ViolationRecord::findOrFail($violationId);
        $violation->update([
            'is_resolved' => $isResolved,
            'resolved_at' => $isResolved ? now() : null,
        ]);

        session()->flash('message', 'Violation status updated successfully.');
        $this->closeModal();
        $this->loadStats();
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->selectedReport = null;
        $this->selectedReportType = null;
    }

    private function loadStats()
    {
        $this->stats = [
            'total_user_reports' => Report::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
            'resolved_reports' => Report::where('status', 'resolved')->count(),
            'total_violations' => ViolationRecord::count(),
            'unresolved_violations' => ViolationRecord::where('is_resolved', false)->count(),
            'total_attendance' => Attendance::count(),
            'today_attendance' => Attendance::where('date', today())->count(),
            'total_lecturer_attendance' => LecturerAttendance::count(),
            'total_bookings' => Booking::count() + FacilityBooking::count() + ShuttleBooking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count() +
                                FacilityBooking::where('status', 'pending')->count() +
                                ShuttleBooking::where('status', 'pending')->count(),
        ];
    }

    public function getReports()
    {
        $reports = collect();

        // Get user reports
        if ($this->reportType === 'all' || $this->reportType === 'user_reports') {
            $userReportsQuery = Report::with(['user', 'assignedTo'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->whereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->statusFilter !== 'all', function ($query) {
                    $query->where('status', $this->statusFilter);
                })
                ->when($this->priorityFilter !== 'all', function ($query) {
                    $query->where('priority', $this->priorityFilter);
                })
                ->when($this->dateFrom, function ($query) {
                    $query->whereDate('created_at', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query) {
                    $query->whereDate('created_at', '<=', $this->dateTo);
                });

            $userReports = $userReportsQuery->get()->map(function ($report) {
                return (object) [
                    'id' => $report->id,
                    'type' => 'user_report',
                    'type_label' => 'User Report',
                    'title' => $report->title,
                    'description' => Str::limit($report->description, 100),
                    'user_name' => $report->user->name,
                    'status' => $report->status,
                    'priority' => $report->priority,
                    'created_at' => $report->created_at,
                ];
            });

            $reports = $reports->concat($userReports);
        }

        // Get violations
        if ($this->reportType === 'all' || $this->reportType === 'violations') {
            $violationsQuery = ViolationRecord::with(['user', 'recorder'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->whereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('violation_type', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->statusFilter !== 'all', function ($query) {
                    if ($this->statusFilter === 'resolved') {
                        $query->where('is_resolved', true);
                    } elseif ($this->statusFilter === 'pending') {
                        $query->where('is_resolved', false);
                    }
                })
                ->when($this->dateFrom, function ($query) {
                    $query->whereDate('violation_date', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query) {
                    $query->whereDate('violation_date', '<=', $this->dateTo);
                });

            $violations = $violationsQuery->get()->map(function ($violation) {
                return (object) [
                    'id' => $violation->id,
                    'type' => 'violation',
                    'type_label' => 'Violation Record',
                    'title' => $violation->violation_type,
                    'description' => Str::limit($violation->description, 100),
                    'user_name' => $violation->user->name,
                    'status' => $violation->is_resolved ? 'resolved' : 'pending',
                    'priority' => $violation->severity,
                    'created_at' => $violation->created_at,
                ];
            });

            $reports = $reports->concat($violations);
        }

        // Get attendance records
        if ($this->reportType === 'all' || $this->reportType === 'attendance') {
            $attendanceQuery = Attendance::with(['user', 'reporter'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->whereHas('user', function ($userQuery) {
                            $userQuery->where('name', 'like', '%' . $this->search . '%');
                        })
                        ->orWhere('status', 'like', '%' . $this->search . '%');
                    });
                })
                ->when($this->statusFilter !== 'all', function ($query) {
                    $query->where('status', $this->statusFilter);
                })
                ->when($this->dateFrom, function ($query) {
                    $query->whereDate('date', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query) {
                    $query->whereDate('date', '<=', $this->dateTo);
                });

            $attendanceRecords = $attendanceQuery->get()->map(function ($attendance) {
                return (object) [
                    'id' => $attendance->id,
                    'type' => 'attendance',
                    'type_label' => 'Student Attendance',
                    'title' => $attendance->user->name . ' - ' . \Carbon\Carbon::parse($attendance->date)->format('d/m/Y'),
                    'description' => 'Check-in: ' . ($attendance->check_in_time ?? 'N/A') . ' | Check-out: ' . ($attendance->check_out_time ?? 'N/A'),
                    'user_name' => $attendance->user->name,
                    'status' => $attendance->status,
                    'priority' => 'normal',
                    'created_at' => $attendance->created_at,
                ];
            });

            $reports = $reports->concat($attendanceRecords);
        }

        // Get lecturer attendance
        if ($this->reportType === 'all' || $this->reportType === 'lecturer_attendance') {
            $lecturerAttendanceQuery = LecturerAttendance::with(['batch.program', 'reporter'])
                ->when($this->search, function ($query) {
                    $query->where(function ($q) {
                        $q->orWhere('lecturer_name', 'like', '%' . $this->search . '%')
                        ->orWhere('subject', 'like', '%' . $this->search . '%')
                        ->orWhereHas('batch.program', function ($programQuery) {
                            $programQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                    });
                })
                ->when($this->statusFilter !== 'all', function ($query) {
                    $query->where('status', $this->statusFilter);
                })
                ->when($this->dateFrom, function ($query) {
                    $query->whereDate('date', '>=', $this->dateFrom);
                })
                ->when($this->dateTo, function ($query) {
                    $query->whereDate('date', '<=', $this->dateTo);
                });

            $lecturerRecords = $lecturerAttendanceQuery->get()->map(function ($record) {
                return (object) [
                    'id' => $record->id,
                    'type' => 'lecturer_attendance',
                    'type_label' => 'Lecturer Attendance',
                    'title' => $record->lecturer_name . ' - ' . $record->subject,
                    'description' => $record->batch->program->name . ' ' . $record->batch->name . ' - ' . \Carbon\Carbon::parse($record->date)->format('d/m/Y'),
                    'user_name' => $record->lecturer_name,
                    'status' => $record->status,
                    'priority' => 'normal',
                    'created_at' => $record->created_at,
                ];
            });

            $reports = $reports->concat($lecturerRecords);
        }

        // Sort combined reports
        $reports = $reports->sortBy([[$this->sortField, $this->sortDirection === 'desc' ? 'desc' : 'asc']]);

        // Paginate
        $page = $this->getPage();
        $perPage = $this->perPage;
        $offset = ($page - 1) * $perPage;

        return new \Illuminate\Pagination\LengthAwarePaginator(
            $reports->slice($offset, $perPage)->values(),
            $reports->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'pageName' => 'page']
        );
    }

    public function render()
    {
        $reports = $this->getReports();

        return view('livewire.admin.reports', compact('reports'));
    }
}