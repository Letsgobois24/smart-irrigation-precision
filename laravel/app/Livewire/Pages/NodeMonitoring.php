<?php

namespace App\Livewire\Pages;

use App\Models\Tree;
use App\Services\FastAPIServices;
use App\Services\InfluxDBService;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Livewire\Component;
use Throwable;

class NodeMonitoring extends Component
{
    public $node_data;
    private $trees = [];

    public function mount(InfluxDBService $influx)
    {
        $this->trees = Tree::getTreeId(1)->toArray();

        try {
            $this->node_data = $this->getSensorData($influx);
        } catch (Throwable $e) {
            dump($e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.pages.node-monitoring');
    }

    public function refresh(InfluxDBService $influx)
    {
        try {
            $this->node_data = $this->getSensorData($influx);
            $this->dispatch("add-data.node");
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
            $this->node_data = $this->getSensorData($influx);
            $this->dispatch("add-data.node");
            $this->dispatch('toast', type: $message['type'], message: $message['message']);
        } catch (ConnectionException) {
            $this->dispatch('toast', type: 'danger', message: "Failed to connect server");
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    private function getSensorData(InfluxDBService $influx)
    {
        $tree_query = implode(',', $this->trees);

        $query = "SELECT 
            DISTINCT ON (tree_id) * FROM node
            WHERE tree_id IN ($tree_query)
            ORDER BY tree_id, time DESC;";

        return $influx->query($query)->convertTimezone()->get();
    }
}
