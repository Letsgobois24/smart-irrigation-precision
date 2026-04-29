<?php

namespace App\Livewire\Components;

use App\Services\FastAPIServices;
use App\Services\InfluxDBService;
use Exception;
use Livewire\Component;
use Throwable;

class NodeMonitoring extends Component
{
    public $node_data;

    public function mount(InfluxDBService $influx)
    {
        try {
            $this->node_data = $this->getData($influx);
        } catch (Throwable $e) {
            dump($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.components.node-monitoring');
    }

    public function refresh(InfluxDBService $influx)
    {
        try {
            $this->node_data = $this->getData($influx);
            $this->dispatch('add-data');
            $this->dispatch('toast', type: 'success', message: 'Data Node 1 berhasil diperbarui');
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    public function fetchNow(FastAPIServices $fastAPIServices, InfluxDBService $influx)
    {
        try {
            $response = $fastAPIServices->requestData('node_1');
            $message = json_decode($response->body(), true);
            if ($response->failed()) {
                throw new Exception(message: $message['detail'] ?? 'Unknown Error', code: $response->status());
            }
            $this->node_data = $this->getData($influx);
            $this->dispatch('add-data');
            $this->dispatch('toast', type: $message['type'], message: $message['message']);
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    private function getData(InfluxDBService $influx)
    {
        $query = "SELECT 
                    tree_id, soil_moisture, valve, time FROM 'node' 
                WHERE time <= now() AND tree_id IN (1,2,3,4)
                ORDER BY time DESC, tree_id 
                LIMIT 4";

        return $influx->query($query)->convertTimezone()->get();
    }
}
