<?php

namespace App\Livewire\Pages;

use App\Models\Tree;
use App\Services\GlobalServices;
use App\Services\InfluxDBService;
use App\Services\NodeServices;
use Illuminate\Support\Collection;
use Livewire\Component;

class Dashboard extends Component
{
    private array $trees = [];

    public function mount()
    {
        $this->trees = Tree::getTreeId(1)->toArray();
    }

    public function render(GlobalServices $globalServices, NodeServices $nodeServices, InfluxDBService $influxDBService)
    {
        $global_data = $globalServices->latest();
        $anomalies = Tree::getTreesWithAnomaly(1)->pluck('notifications_count', 'tree_id');

        $node_data = $nodeServices->latest($this->trees);
        $node_data = $this->joinNodeData($node_data, $anomalies);

        $energy_data = $this->getEnergyLatest($influxDBService);

        return view(
            'livewire.pages.dashboard',
            compact('global_data', 'node_data', 'energy_data')
        );
    }

    private function joinNodeData(Collection $node_data, Collection $anomalies)
    {
        return $node_data->map(function ($item) use ($anomalies) {
            $item['total_anomaly'] = $anomalies[$item['tree_id']] ?? 0;
            return $item;
        });
    }

    private function getEnergyLatest(InfluxDBService $influxDBService)
    {
        $query = "SELECT * 
                FROM 'energy' 
                WHERE time <= now() + INTERVAL '7 hours'
                ORDER BY TIME DESC 
                LIMIT 1";
        return $influxDBService->query($query)->convertTimezone()->get()[0];
    }
}
