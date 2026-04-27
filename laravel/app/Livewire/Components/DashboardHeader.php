<?php

namespace App\Livewire\Components;

use App\Models\Configuration;
use Livewire\Component;
use Throwable;

class DashboardHeader extends Component
{
    public $now;
    public bool $system_active;

    public function mount()
    {
        $this->now = now()->millisecond();
        $this->system_active = Configuration::find(1)['is_active'];
    }

    public function render()
    {
        return view('livewire.components.dashboard-header');
    }

    public function toggleSystem()
    {
        try {
            $this->system_active = !$this->system_active;
            Configuration::where('id', 1)->update(['is_active' => $this->system_active]);

            $message = 'Sistem berhasil ' . ($this->system_active ? 'diaktifkan' : 'dimatikan');
            $this->dispatch('toast', type: 'success', message: $message);
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }
}
