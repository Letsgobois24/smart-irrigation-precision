<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use App\Models\Tree;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class NotificationModal extends Component
{
    public $active_notification = [];
    public array | null $notifications = null;
    public int $count_notifications;
    private int $limit = 20;
    public int $offset = 0;

    public bool $isMaxLoaded = false;
    public bool $isNotificationLoaded;

    // Filter Options
    public array $date_range;
    public array $locations = [];
    public array $severities = [
        '' => [
            'name' => 'All',
            'color' => 'gray'
        ],
        'rendah' => [
            'name' => 'Low',
            'color' => 'green'
        ],
        'sedang' => [
            'name' => 'Medium',
            'color' => 'yellow'
        ],
        'tinggi' => [
            'name' => 'High',
            'color' => 'red'
        ],
    ];

    public array $statuses = [
        '' => [
            'name' => 'All',
            'color' => 'gray'
        ],
        '0' => [
            'name' => 'Active',
            'color' => 'blue'
        ],
        '1' => [
            'name' => 'Resolved',
            'color' => 'green'
        ],
    ];

    // Selected Filter
    public string $selected_severity = '';
    public string $selected_status = '';
    public string $startDate = '';
    public string $endDate = '';
    public string $selected_location = '';

    #[On('add-data.global')]
    #[On('add-data.node')]
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
        if ($this->active_notification['id'] == $id) return;
        $this->active_notification = Notification::find($id);
    }

    public function openNotification()
    {
        if ($this->isNotificationLoaded) return;

        $trees = Tree::select('tree_id')->active()->orderBy('tree_id')->pluck('tree_id');
        $locations['all'] = 'All';
        $locations['global'] = 'Global';
        foreach ($trees as $tree) {
            $locations[$tree] = 'Tree ' . $tree;
        }
        $this->locations = $locations;

        $this->date_range = $this->getDateRange();

        $this->updateNotifications();
        $this->isNotificationLoaded = true;
    }

    public function resolve()
    {
        $id = $this->active_notification['id'];
        $is_active = $this->active_notification['is_active'];
        try {
            Notification::where('id', $id)->update(['is_active' => !$is_active]);
            $message = 'Masalah ' . $this->active_notification['title'] . ' ' . (!$is_active ? 'batal menyelesaikan' : 'telah terselesaikan');
            $this->dispatch('toast', type: 'success', message: $message);
            $this->active_notification['is_active'] = !$is_active;
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: 'Error: ' . $e->getMessage());
        }

        $this->updateNotifications($id);
    }

    public function loadMore()
    {
        $this->offset += $this->limit;
        $new_notifications = $this->getAllNotifications();

        // Cek apabila list sudah load semua notifikasi
        if (count($new_notifications) < $this->limit) {
            $this->isMaxLoaded = true;
        }

        $this->notifications = array_merge($this->notifications, $new_notifications);
    }

    public function setSeverity(string $severity)
    {
        $this->selected_severity = $severity;
        $this->filterNotifications();
    }

    public function setStatus(string $is_active)
    {
        $this->selected_status = $is_active;
        $this->filterNotifications();
    }

    public function applyDateRange()
    {
        dump($this->startDate);
        dump($this->endDate);
        $this->filterNotifications();
    }

    public function setLocation()
    {
        $this->filterNotifications();
        dump($this->selected_location);
    }

    private function filterNotifications()
    {
        dump('filterNotifications');
    }

    private function getDateRange()
    {
        $from = Notification::orderBy('created_at', 'asc')->value('created_at');
        $to = Notification::orderBy('created_at', 'asc')->value('created_at');

        return compact('from', 'to');
    }

    private function updateNotifications(null | int $active_id = null)
    {
        $this->count_notifications = Notification::where('is_active', 1)->count();
        $this->notifications = $this->getAllNotifications();

        if (count($this->notifications) > 0) {
            $active_id = $active_id ?? $this->notifications[0]['id'];
            $this->active_notification = Notification::find($active_id);
        }
    }

    private function getAllNotifications()
    {
        return Notification::select(['id', 'title', 'source_type', 'created_at', 'severity', 'is_active', 'tree_id'])
            ->orderBy('is_active', 'desc')
            ->orderBy('created_at', 'desc')
            ->offset($this->offset)
            ->limit($this->limit)
            ->get()
            ->map(function ($row) {
                return [
                    ...$row->toArray(),
                    'created_at' => $row->created_at->diffForHumans()
                ];
            })
            ->toArray();
    }

    // Component Function
    public function getConfigClass(string $severity): array
    {
        return match ($severity) {
            'rendah' => [
                'badge' => 'green',
                'text' => 'text-green-700'
            ],
            'sedang' => [
                'badge' => 'yellow',
                'text' => 'text-yellow-700'
            ],
            'tinggi' => [
                'badge' => 'red',
                'text' => 'text-red-700'
            ],
        };
    }
}
