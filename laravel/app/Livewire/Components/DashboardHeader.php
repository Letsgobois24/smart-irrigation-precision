<?php

namespace App\Livewire\Components;

use App\Models\Configuration;
use App\Services\FastAPIServices;
use Exception;
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

    public function toggleSystem(FastAPIServices $fastAPIServices)
    {
        try {
            $system_active = !$this->system_active;
            // Update configuration

            $response = $fastAPIServices->globalControl([
                'is_active' => $system_active
            ]);

            if ($response->failed()) {
                $message = json_decode($response->body(), true);
                throw new Exception(message: $message['detail'] ?? 'Unknown Error', code: $response->status());
            }

            Configuration::where('id', 1)->update(['is_active' => $system_active]);

            $this->system_active = $system_active;
            $message = 'Sistem berhasil ' . ($this->system_active ? 'diaktifkan' : 'dimatikan');
            $this->dispatch('toast', type: 'success', message: $message);
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }
}
