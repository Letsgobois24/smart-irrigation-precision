<?php

namespace App\Livewire\Pages;

use App\Models\Notification;
use App\Models\Tree;
use App\Services\InfluxDBService;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class Location extends Component
{
    public int $max_col = 0;

    public function mount()
    {
        $this->max_col = Tree::max('col_idx');
    }

    public function render()
    {
        $trees = Tree::withCount([
            'notifications' => function (Builder $query) {
                $query->where('notifications.is_active', true);
            }
        ])->get();

        // Summary Tree
        $summary = Tree::getSummary();
        $summary['total_anomaly'] = Notification::isTree()->isActive()->count();

        return view('livewire.pages.location', compact('trees', 'summary'));
    }
}
