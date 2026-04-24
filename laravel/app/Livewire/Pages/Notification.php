<?php

namespace App\Livewire\Pages;

use App\Models\Notification as ModelsNotification;
use Illuminate\Foundation\Concerns\ResolvesDumpSource;
use Livewire\Component;

class Notification extends Component
{
    public function render()
    {
        return view('livewire.pages.notification');
    }
}
