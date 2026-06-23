<?php

namespace App\Livewire\Pages;

use App\Models\Tree;
use App\Services\FastAPIServices;
use App\Services\NodeServices;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Livewire\Component;
use Throwable;

class NodeMonitoring extends Component
{
    public $trees = [];
    public $refresh_child = true;

    public function mount()
    {
        $this->trees = Tree::getTreeId(1)->toArray();
    }

    public function render(NodeServices $nodeServices)
    {
        $anomalies = Tree::getTreesWithAnomaly(1)->pluck('notifications_count', 'tree_id');

        $node_data = $nodeServices->latest($this->trees);
        $node_data = collect($node_data)
            ->map(function ($item) use ($anomalies) {
                $item['total_anomaly'] = $anomalies[$item['tree_id']] ?? 0;
                return $item;
            });
        return view('livewire.pages.node-monitoring', compact('node_data'));
    }

    public function refresh()
    {
        try {
            $this->dispatch('toast', type: 'success', message: 'Data Node 1 berhasil diperbarui');
            $this->refresh_child = !$this->refresh_child;
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    public function fetchNow(FastAPIServices $fastAPIServices)
    {
        try {
            $response = $fastAPIServices->requestData('node_1');
            $message = json_decode($response->body(), true);
            if ($response->failed()) {
                throw new Exception(message: $message['detail'] ?? 'Unknown Error', code: $response->status());
            }
            $this->refresh_child = !$this->refresh_child;
            $this->dispatch('toast', type: $message['type'], message: $message['message']);
        } catch (ConnectionException) {
            $this->dispatch('toast', type: 'danger', message: "Failed to connect server");
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }
}
