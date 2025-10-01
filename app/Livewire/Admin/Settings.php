<?php

namespace App\Livewire\Admin;

use App\Models\SystemSetting;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Cache;

class Settings extends Component
{
    use WithPagination;

    public $search = '';
    public $categoryFilter = 'all';
    public $editingSetting = null;
    public $editValue = '';
    public $editDescription = '';
    public $showCreateModal = false;
    public $newSetting = [
        'key' => '',
        'value' => '',
        'type' => 'string',
        'description' => '',
        'category' => 'general'
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryFilter' => ['except' => 'all']
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Clear cache to ensure fresh data
        Cache::forget('system_settings');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function getSettingsProperty()
    {
        $query = SystemSetting::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('key', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->categoryFilter !== 'all') {
            $query->where('category', $this->categoryFilter);
        }

        return $query->orderBy('category')
                    ->orderBy('key')
                    ->paginate(15);
    }

    public function getCategoriesProperty()
    {
        return SystemSetting::distinct('category')->pluck('category');
    }

    public function editSetting($settingId)
    {
        $setting = SystemSetting::find($settingId);
        if ($setting) {
            $this->editingSetting = $settingId;
            $this->editValue = $setting->value;
            $this->editDescription = $setting->description;
        }
    }

    public function updateSetting()
    {
        $this->validate([
            'editValue' => 'required',
            'editDescription' => 'nullable|string|max:255'
        ]);

        $setting = SystemSetting::find($this->editingSetting);
        if ($setting) {
            $setting->update([
                'value' => $this->editValue,
                'description' => $this->editDescription
            ]);

            $this->loadSettings();
            session()->flash('message', 'Pengaturan berhasil diperbarui.');
        }

        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->editingSetting = null;
        $this->editValue = '';
        $this->editDescription = '';
    }

    public function createSetting()
    {
        $this->validate([
            'newSetting.key' => 'required|string|unique:system_settings,key',
            'newSetting.value' => 'required',
            'newSetting.type' => 'required|in:string,integer,boolean,json',
            'newSetting.description' => 'nullable|string|max:255',
            'newSetting.category' => 'required|string'
        ]);

        SystemSetting::create($this->newSetting);

        $this->loadSettings();
        $this->resetNewSetting();
        $this->showCreateModal = false;
        session()->flash('message', 'Pengaturan baru berhasil dibuat.');
    }

    public function deleteSetting($settingId)
    {
        $setting = SystemSetting::find($settingId);
        if ($setting) {
            $setting->delete();
            $this->loadSettings();
            session()->flash('message', 'Pengaturan berhasil dihapus.');
        }
    }

    public function resetNewSetting()
    {
        $this->newSetting = [
            'key' => '',
            'value' => '',
            'type' => 'string',
            'description' => '',
            'category' => 'general'
        ];
    }

    public function render()
    {
        return view('livewire.admin.settings', [
            'settings' => $this->settings,
            'categories' => $this->categories
        ]);
    }
}