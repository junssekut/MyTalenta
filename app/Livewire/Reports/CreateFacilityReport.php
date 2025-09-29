<?php

namespace App\Livewire\Reports;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CreateFacilityReport extends Component
{
    use WithFileUploads;

    public $title = '';
    public $description = '';
    public $location = '';
    public $priority = 'medium';
    public $photos = [];
    public $isSubmitting = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'location' => 'required|string|max:255',
        'priority' => 'required|in:low,medium,high',
        'photos.*' => 'nullable|image|max:2048', // Max 2MB per image
    ];

    protected $messages = [
        'title.required' => 'Judul laporan wajib diisi.',
        'description.required' => 'Deskripsi kerusakan wajib diisi.',
        'location.required' => 'Lokasi kerusakan wajib diisi.',
        'photos.*.image' => 'File harus berupa gambar.',
        'photos.*.max' => 'Ukuran gambar maksimal 2MB.',
    ];

    public function submitReport()
    {
        $this->validate();

        $this->isSubmitting = true;

        try {
            $photoPaths = [];

            // Store uploaded photos
            if ($this->photos) {
                foreach ($this->photos as $photo) {
                    $photoPaths[] = $photo->store('reports/facility', 'public');
                }
            }

            // Create the report
            Report::create([
                'user_id' => auth()->id(),
                'type' => 'facility_damage',
                'title' => $this->title,
                'description' => $this->description,
                'location' => $this->location,
                'priority' => $this->priority,
                'photos' => $photoPaths,
                'status' => 'pending',
            ]);

            // Reset form
            $this->reset(['title', 'description', 'location', 'priority', 'photos']);

            session()->flash('success', 'Laporan kerusakan fasilitas berhasil dikirim!');

            // Redirect to dashboard or show success message
            return redirect()->route('dashboard')->with('success', 'Laporan kerusakan fasilitas berhasil dikirim!');

        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat mengirim laporan. Silakan coba lagi.');
        } finally {
            $this->isSubmitting = false;
        }
    }

    public function removePhoto($index)
    {
        unset($this->photos[$index]);
        $this->photos = array_values($this->photos); // Reindex array
    }

    public function render()
    {
        return view('livewire.reports.create-facility-report');
    }
}