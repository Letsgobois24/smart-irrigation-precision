<?php

namespace App\Livewire\Components;

use App\Models\Notification;
use App\Models\NotificationRule;
use App\Models\Tree;
use App\Services\InfluxDBService;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;
use Throwable;

class NotificationModal extends Component
{
    public $active_notification = [];
    public array | null $notifications = null;
    public int $total_active = 0;
    public int $total_result = 0;
    public array $detail_prediction = [];

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
        'low' => [
            'name' => 'Low',
            'color' => 'green'
        ],
        'medium' => [
            'name' => 'Medium',
            'color' => 'yellow'
        ],
        'high' => [
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

    public function mount()
    {
        $this->total_active = Notification::isActive()->count();
        $this->isNotificationLoaded = false;
    }

    public function render()
    {
        return view('livewire.components.notification-modal');
    }

    public function openNotification()
    {
        // Jika sudah diload tidak akan melanjutkan
        if ($this->isNotificationLoaded) return;

        // Set location select options
        $trees = Tree::getOptions();
        $this->locations = $this->locations + $trees;

        $this->date_range = $this->getDateRange();

        $this->updateNotifications();
        $this->isNotificationLoaded = true;
    }

    public function detailNotification(int $id)
    {
        if ($this->active_notification['id'] == $id) return;
        $this->reset('detail_prediction');
        $this->active_notification = $this->getActiveNotification($id);
    }

    public function resolve()
    {
        $id = $this->active_notification['id'];
        $is_active = $this->active_notification['is_active'];
        try {
            Notification::where('id', $id)->update(['is_active' => !$is_active]);
            $message = 'Masalah ' . strtolower($this->active_notification['rule']['title']) . ' ' . (!$is_active ? 'batal menyelesaikan' : 'telah terselesaikan');
            $this->dispatch('toast', type: 'success', message: $message);
            $this->active_notification['is_active'] = !$is_active;
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: 'Error: ' . $e->getMessage());
        }

        $this->reset('offset');

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

    public function showResultPrediction(string $event_id, InfluxDBService $influxDBService)
    {
        $query = "SELECT * FROM 'predictions' where event_id = '$event_id' LIMIT 1";
        $this->detail_prediction = $influxDBService->query($query)->first() ?? [];

        $parameters = Cache::rememberForever("parameters", function () {
            return NotificationRule::query()
                ->select(['feature', 'name'])
                ->get();
        });

        $parameters = $parameters->map(function ($rule) {
            $value = $this->detail_prediction["mse_{$rule->feature}"] ?? 0;
            return [
                'feature' => $rule->feature,
                'name' => $rule->name,
                'value' => (float) $value,
            ];
        })
            ->sortByDesc('value')
            ->values()
            ->toArray();

        $maxValue = max(array_column($parameters, 'value'));

        foreach ($parameters as &$parameter) {
            $percentage = round($parameter['value'] / $maxValue * 100, 2);
            $parameter['percentage'] = $percentage;
            $parameter['color'] = $this->getErrorColor($percentage);
        }

        $this->detail_prediction['parameters'] = $parameters;
    }

    public function getErrorColor(float $percentage): array
    {
        return match (true) {
            $percentage >= 80 => [
                'bg' => 'bg-red-500',
                'card' => 'bg-red-50 border-red-200',
                'text' => 'text-red-700',
            ],

            $percentage >= 60 => [
                'bg' => 'bg-orange-500',
                'card' => 'bg-orange-50 border-orange-200',
                'text' => 'text-orange-700',
            ],

            $percentage >= 40 => [
                'bg' => 'bg-yellow-500',
                'card' => 'bg-yellow-50 border-yellow-200',
                'text' => 'text-yellow-700',
            ],

            default => [
                'bg' => 'bg-green-500',
                'card' => 'bg-green-50 border-green-200',
                'text' => 'text-green-700',
            ],
        };
    }

    #[On('filter-location')]
    public function setNotificationByLocation(string $tree_id)
    {
        $this->reset('offset', 'selected_severity', 'start_date', 'end_date', 'isMaxLoaded');
        $this->selected_location = $tree_id;
        $this->selected_status = 1;
        $this->setLocation();

        if (count($this->notifications) > 0) {
            $active_id = $this->notifications[0]['id'];
            $this->active_notification = $this->getActiveNotification($active_id);
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
            $this->active_notification = $this->getActiveNotification($active_id);
        }
    }

    private function getAllNotifications(): array
    {
        $filters = $this->getFilterConfig();
        $notifications = Notification::select(['id', 'tree_id', 'dominant_feature', 'severity', 'is_active', 'created_at'])
            ->with('rule:feature,title')
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

    private function getActiveNotification(null | int $active_id = null): array
    {
        $notification = Notification::with('rule')->find($active_id ?? $this->active_notification['id'])->toArray();

        $notification['created_at'] = \Carbon\Carbon::parse($notification['created_at'])
            ->addHours(7)
            ->format('d M Y H:i:s');

        return $notification;
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
            'low' => [
                'badge' => 'green',
                'text' => 'text-green-700'
            ],
            'medium' => [
                'badge' => 'yellow',
                'text' => 'text-yellow-700'
            ],
            'high' => [
                'badge' => 'red',
                'text' => 'text-red-700'
            ],
        };
    }
}
