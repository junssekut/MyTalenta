<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Role;
use App\Models\Batch;
use App\Models\Program;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class Users extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    // Form properties
    public $showCreateModal = false;
    public $showEditModal = false;
    public $editingUserId = null;

    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $student_id = '';
    public $card_id = '';
    public $role_id = '';
    public $batch_id = '';
    public $phone = '';
    public $address = '';
    public $gender = '';
    public $date_of_birth = '';
    public $emergency_contact_name = '';
    public $emergency_contact_phone = '';
    public $is_active = true;

    protected $queryString = [
        'search' => ['except' => ''],
        'perPage' => ['except' => 10],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($this->editingUserId)
            ],
            'student_id' => 'nullable|string|max:255|unique:users,student_id,' . $this->editingUserId,
            'card_id' => 'nullable|string|max:255|unique:users,card_id,' . $this->editingUserId,
            'role_id' => 'required|exists:roles,id',
            'batch_id' => 'nullable|exists:batches,id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date|before:today',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ];

        if (!$this->editingUserId) {
            $rules['password'] = 'required|string|min:8|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:8|confirmed';
        }

        return $rules;
    }

    public function updatedSearch()
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

    public function create()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function edit($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUserId = $userId;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->student_id = $user->student_id;
        $this->card_id = $user->card_id;
        $this->role_id = $user->role_id;
        $this->batch_id = $user->batch_id;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->gender = $user->gender;
        $this->date_of_birth = $user->date_of_birth;
        $this->emergency_contact_name = $user->emergency_contact_name;
        $this->emergency_contact_phone = $user->emergency_contact_phone;
        $this->is_active = $user->is_active;
        $this->password = '';
        $this->password_confirmation = '';
        $this->showEditModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'student_id' => $this->student_id,
            'card_id' => $this->card_id,
            'role_id' => $this->role_id,
            'batch_id' => $this->batch_id,
            'phone' => $this->phone,
            'address' => $this->address,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
            'is_active' => $this->is_active,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->editingUserId) {
            User::findOrFail($this->editingUserId)->update($data);
            session()->flash('message', 'User updated successfully.');
        } else {
            User::create($data);
            session()->flash('message', 'User created successfully.');
        }

        $this->closeModal();
    }

    public function delete($userId)
    {
        User::findOrFail($userId)->delete();
        session()->flash('message', 'User deleted successfully.');
    }

    public function toggleActive($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['is_active' => !$user->is_active]);
        session()->flash('message', 'User status updated successfully.');
    }

    public function closeModal()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->editingUserId = null;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->student_id = '';
        $this->card_id = '';
        $this->role_id = '';
        $this->batch_id = '';
        $this->phone = '';
        $this->address = '';
        $this->gender = '';
        $this->date_of_birth = '';
        $this->emergency_contact_name = '';
        $this->emergency_contact_phone = '';
        $this->is_active = true;
    }

    public function render()
    {
        $users = User::with(['role', 'batch.program'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('student_id', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $roles = Role::all();
        $batches = Batch::with('program')->get();

        return view('livewire.admin.users', compact('users', 'roles', 'batches'));
    }
}