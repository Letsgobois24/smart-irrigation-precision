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

    public function mount()
    {
        $this->trees = Tree::getTreeId(1)->toArray();
    }

    public function render(NodeServices $nodeServices)
    {
        $node_data = $nodeServices->latest($this->trees);
        return view('livewire.pages.node-monitoring', compact('node_data'));
    }

    public function refresh()
    {
        try {
            $this->dispatch('toast', type: 'success', message: 'Data Node 1 berhasil diperbarui');
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
            $this->dispatch("add-data.node");
            $this->dispatch('toast', type: $message['type'], message: $message['message']);
        } catch (ConnectionException) {
            $this->dispatch('toast', type: 'danger', message: "Failed to connect server");
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }
}
