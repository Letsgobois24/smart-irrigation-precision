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
    public int $total_active = 0;
    public int $total_result = 0;

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
        '1' => [
            'name' => 'Active',
            'color' => 'blue'
        ],
        '0' => [
            'name' => 'Resolved',
            'color' => 'green'
        ]
    ];

    // Selected Filter
    public string $selected_severity = '';
    public string $selected_status = '';
    public string $start_date = '';
    public string $end_date = '';
    public string $selected_location = '';

    #[On('add-data.global')]
    #[On('add-data.node')]
    public function mount()
    {
        $this->total_active = Notification::isActive()->count();
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
        $locations[''] = 'All';
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
        $this->total_active = Notification::isActive()->count();
    }

    public function loadMore()
    {
        $this->offset += $this->limit;
        $new_notifications = $this->getAllNotifications();

        $this->notifications = array_merge($this->notifications, $new_notifications);

        // Cek apabila list sudah load semua notifikasi
        if (count($this->notifications) >= $this->total_result) {
            $this->isMaxLoaded = true;
        }
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

    public function setDateRange()
    {
        $this->filterNotifications();
    }

    public function setLocation()
    {
        $this->filterNotifications();
    }

    public function resetFilter()
    {
        $this->reset('offset', 'selected_severity', 'selected_status', 'start_date', 'end_date', 'selected_location', 'isMaxLoaded');
        $this->notifications = $this->getAllNotifications();
        $this->updateTotalResult();
    }

    private function filterNotifications()
    {
        $this->reset('offset', 'isMaxLoaded');
        $this->notifications = $this->getAllNotifications();
        $this->updateTotalResult();
    }

    private function getDateRange()
    {
        $from = Notification::orderBy('created_at', 'asc')->value('created_at');
        $to = Notification::orderBy('created_at', 'desc')->value('created_at');

        return compact('from', 'to');
    }

    private function updateNotifications(null | int $active_id = null)
    {
        $this->notifications = $this->getAllNotifications();
        $this->updateTotalResult();

        if (count($this->notifications) > 0) {
            $active_id = $active_id ?? $this->notifications[0]['id'];
            $this->active_notification = Notification::find($active_id);
        }
    }

    private function getAllNotifications(): array
    {
        $filters = $this->getFilterConfig();
        $notifications = Notification::select(['id', 'title', 'source_type', 'created_at', 'severity', 'is_active', 'tree_id'])
            ->filter($filters)
            ->activeOrder($this->selected_status)
            ->orderBy('created_at', 'desc')
            ->offset($this->offset)
            ->limit($this->limit);

        return $notifications
            ->get()
            ->map(function ($row) {
                return [
                    ...$row->toArray(),
                    'created_at' => $row->created_at->diffForHumans()
                ];
            })
            ->toArray();
    }

    // Update total result
    private function updateTotalResult(): void
    {
        $filters = $this->getFilterConfig();
        $this->total_result = Notification::filter($filters)->count();
    }

    private function getFilterConfig()
    {
        return [
            'severity' => $this->selected_severity,
            'is_active' => $this->selected_status,
            'location' => $this->selected_location,
            'date' => [
                'from' => $this->start_date,
                'to' => $this->end_date
            ],
        ];
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
