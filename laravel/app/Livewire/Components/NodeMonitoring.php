<?php

namespace App\Livewire\Components;

use App\Services\InfluxService;
use Livewire\Component;

class NodeMonitoring extends Component
{
    public $node_data;

    public function mount()
    {
        $this->node_data = $this->updateData();
    }

    public function render()
    {
        return view('livewire.components.node-monitoring');
    }

    public function getDataNow()
    {
        $this->node_data = $this->updateData();
        $this->dispatch('toast', type: 'success', message: 'Node 1 data has been updated');
    }

    public function updateData()
    {
        $influxService = new InfluxService;

        $query = "
        SELECT tree_id, soil_moisture, valve, time FROM 'nodes' 
        WHERE tree_id IN (1,2,3,4)
        ORDER BY time, tree_id 
        LIMIT 4
        ";

        return $influxService->query($query);
    }
}
