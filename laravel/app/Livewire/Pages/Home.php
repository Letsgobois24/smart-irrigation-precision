<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Throwable;

class Home extends Component
{
    public $now;
    public bool $system_active = true;

    public function mount()
    {
        $this->now = now()->millisecond();
    }

    public function render()
    {
        return view('livewire.pages.home');
    }

    public function toggleSystem()
    {
        sleep(1);
        try {
            $this->system_active = !$this->system_active;
            $message = 'Sistem berhasil ' . ($this->system_active ? 'diaktifkan' : 'dimatikan');
            $this->dispatch('toast', type: 'success', message: $message);
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }
}
