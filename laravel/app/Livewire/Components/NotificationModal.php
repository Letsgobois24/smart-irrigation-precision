<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class NotificationModal extends Component
{
    public $active_notification = [];
    public array | null $notifications = null;
    public int $count_notifications;

    public bool $isNotificationLoaded;

    #[On('add-data')]
    public function mount()
    {
        $this->count_notifications = Notification::where('is_active', 1)->count();
        $this->isNotificationLoaded = false;
    }

    public function render()
    {
        return view('livewire.components.notification-modal');
    }

    public function detailNotification(int $id)
    {
        $this->active_notification = Notification::find($id)->toArray();
    }

    public function openNotification()
    {
        if ($this->isNotificationLoaded) return;
        $this->updateNotifications();
        $this->isNotificationLoaded = true;
    }

    public function resolve()
    {
        $id = $this->active_notification['id'];
        $is_active = $this->active_notification['is_active'];
        try {
            $response = Notification::where('id', $id)->update(['is_active' => !$is_active]);
            $message = 'Masalah ' . $this->active_notification['title'] . ' ' . (!$is_active ? 'batal menyelesaikan' : 'telah terselesaikan');
            $this->dispatch('toast', type: 'success', message: $message);
            $this->active_notification['is_active'] = !$is_active;
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: 'Error: ' . $e->getMessage());
        }

        $this->updateNotifications($id);
    }

    private function updateNotifications(int | null $active_id = null)
    {
        $this->notifications = Notification::select(['id', 'title', 'source_type', 'created_at', 'severity', 'is_active', 'tree_id'])
            ->orderBy('is_active', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()->toArray();

        if (count($this->notifications) > 0) {
            $id = $active_id ?? $this->notifications[0]['id'];
            $this->active_notification = Notification::find($id);
        }
    }
}
