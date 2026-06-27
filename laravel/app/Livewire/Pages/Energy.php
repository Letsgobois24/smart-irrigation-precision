<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Energy extends Component
{
    public bool $refresh_child = true;

    public function render()
    {
        return view('livewire.pages.energy');
    }
}
