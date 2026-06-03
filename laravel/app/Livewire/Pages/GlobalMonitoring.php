<?php

namespace App\Livewire\Pages;

use App\Services\FastAPIServices;
use App\Services\GlobalServices;
use Exception;
use Illuminate\Http\Client\ConnectionException;
use Livewire\Component;
use Throwable;

class GlobalMonitoring extends Component
{
    public array $data;

    public function mount(GlobalServices $globalServices)
    {
        $this->loadData($globalServices);
    }

    public function render()
    {
        return view('livewire.pages.global-monitoring');
    }

    public function refresh(GlobalServices $globalServices)
    {
        try {
            $this->loadData($globalServices);
            $this->dispatch("add-data.global");
            $this->dispatch('toast', type: 'success', message: 'Data berhasil diperbarui');
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    public function fetchNow(FastAPIServices $fastAPIServices, GlobalServices $globalServices)
    {
        try {
            $response = $fastAPIServices->requestData('global');
            $message = json_decode($response->body(), true);
            if ($response->failed()) {
                throw new Exception(message: $message['detail'] ?? 'Unknown Error', code: $response->status());
            }
            $this->update($globalServices);
            $this->dispatch("add-data.global");
            $this->dispatch('toast', type: $message['type'], message: $message['message']);
        } catch (ConnectionException) {
            $this->dispatch('toast', type: 'danger', message: "Failed to connect server");
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    private function loadData(GlobalServices $globalServices)
    {
        $this->data = $globalServices->latest();
    }
}
