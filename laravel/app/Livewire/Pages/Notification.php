<?php

namespace App\Livewire\Pages;

use App\Models\Notification as ModelsNotification;
use Illuminate\Foundation\Concerns\ResolvesDumpSource;
use Livewire\Component;

class Notification extends Component
{
    public $active_notification;
    public $notifications;

    public function mount()
    {
        $this->notifications = ModelsNotification::all(['id', 'title', 'source_type', 'created_at']);
        $this->active_notification = ModelsNotification::find($this->notifications[0]['id']);
        // dd($this->active_notification);
    }

    public function render()
    {
        return view('livewire.pages.notification');
    }

    public function detailNotification(int $id)
    {
        $this->active_notification = ModelsNotification::find($id);
    }
}
