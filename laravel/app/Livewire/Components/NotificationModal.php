<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use Livewire\Component;
use Throwable;

class NotificationModal extends Component
{
    public $active_notification;
    public $notifications;

    public function mount()
    {
        $this->notifications = Notification::select(['id', 'title', 'source_type', 'created_at', 'severity', 'is_active', 'tree_id'])->orderBy('is_active', 'desc')->get();
        $this->active_notification = Notification::find($this->notifications[0]['id']);
    }

    public function detailNotification(int $id)
    {
        $this->active_notification = Notification::find($id);
    }

    public function render()
    {
        $count_notifications = Notification::where('is_active', 1)->count();
        return view('livewire.components.notification-modal', [
            'count_notifications' => $count_notifications
        ]);
    }

    public function resolve()
    {
        $id = $this->active_notification['id'];
        $is_active = $this->active_notification['is_active'];
        try {
            $response = Notification::where('id', $id)->update(['is_active' => !$is_active]);
            $message = 'Masalah ' . $this->active_notification['title'] . ' ' . (!$is_active ? 'belum' : 'telah') .  ' terselesaikan';
            $this->dispatch('toast', type: 'success', message: $message);
            $this->active_notification['is_active'] = !$is_active;
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: 'Error: ' . $e->getMessage());
        }
    }
}
