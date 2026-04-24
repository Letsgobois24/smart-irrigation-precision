<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use Livewire\Component;

class NotificationModal extends Component
{
    public $active_notification;
    public $notifications;

    public function mount()
    {
        $this->notifications = Notification::all(['id', 'title', 'source_type', 'created_at']);
        $this->active_notification = Notification::find($this->notifications[0]['id']);
        // dd($this->active_notification);
    }

    public function detailNotification(int $id)
    {
        $this->active_notification = Notification::find($id);
    }

    public function render()
    {
        return view('livewire.components.notification-modal');
    }
}
