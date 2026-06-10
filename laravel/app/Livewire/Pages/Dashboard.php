<?php

namespace App\Livewire\Pages;

use App\Models\Tree;
use App\Services\GlobalServices;
use App\Services\NodeServices;
use Livewire\Component;

class Dashboard extends Component
{
    private $trees = [];

    public function mount()
    {
        $this->trees = Tree::getTreeId(1)->toArray();
    }

    public function render(GlobalServices $globalServices, NodeServices $nodeServices)
    {
        $global_data = $globalServices->latest();
        $anomalies = Tree::getTreesWithAnomaly(1)->pluck('notifications_count', 'tree_id');

        $node_data = $nodeServices->latest($this->trees);
        $node_data = $this->joinNodeData($node_data, $anomalies);
        return view(
            'livewire.pages.dashboard',
            compact('global_data', 'node_data')
        );
    }

    private function joinNodeData(array $node_data, array $anomalies)
    {
        return collect($node_data)
            ->map(function ($item) use ($anomalies) {
                $item['total_anomaly'] = $anomalies[$item['tree_id']] ?? 0;
                return $item;
            });
    }
}
