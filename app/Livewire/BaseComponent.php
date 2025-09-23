<?php

namespace App\Livewire;

use Livewire\Component;

abstract class BaseComponent extends Component
{
    public function getLayoutProperty()
    {
        $user = auth()->user();
        
        if (!$user || !$user->role) {
            return 'layouts.mobile';
        }

        // Mobile layout for students
        if (in_array($user->role->name, ['mahasiswa', 'komti', 'wakomti', 'sekretaris_kelas'])) {
            return 'layouts.mobile';
        }
        
        // Sidebar layout for PIC and admin roles
        return 'layouts.sidebar';
    }

    public function render()
    {
        return view($this->getViewName())
            ->layout($this->layout);
    }

    abstract protected function getViewName(): string;
}
