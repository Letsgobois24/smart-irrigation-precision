<?php

namespace App\Livewire\Components;

use Livewire\Component;

class GlobalMonitoring extends Component
{
    public function render()
    {
        return view('livewire.components.global-monitoring');
    }

    public function getDataNow()
    {
        $this->dispatch('toast', type: 'success', message: 'Data has been updated');
    }
}
