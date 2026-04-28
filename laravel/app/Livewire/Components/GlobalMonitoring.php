<?php

namespace App\Livewire\Components;

use App\Services\FastAPIServices;
use App\Services\InfluxDBService;
use Exception;
use Livewire\Component;
use Throwable;

class GlobalMonitoring extends Component
{
    public int $ph;
    public float $water_flow;
    public bool $main_valve;
    public $time;

    public function mount(InfluxDBService $influx)
    {
        $this->update($influx);
    }

    public function render()
    {
        return view('livewire.components.global-monitoring');
    }

    public function refresh(InfluxDBService $influx)
    {
        try {
            $this->update($influx);
            $this->dispatch('add-data');
            $this->dispatch('toast', type: 'success', message: 'Data berhasil diperbarui');
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    public function fetchNow(FastAPIServices $fastAPIServices, InfluxDBService $influx)
    {
        try {
            $response = $fastAPIServices->requestData('global');
            $message = json_decode($response->body(), true);
            if ($response->failed()) {
                throw new Exception(message: $message['detail'] ?? 'Unknown Error', code: $response->status());
            }
            $this->update($influx);
            $this->dispatch('add-data');
            $this->dispatch('toast', type: $message['type'], message: $message['message']);
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    private function update(InfluxDBService $influx)
    {
        $query = "SELECT * 
                FROM 'environment' 
                WHERE time <= now() + INTERVAL '7 hours'
                ORDER BY TIME DESC 
                LIMIT 1";
        $data = $influx->query($query)->convertTimezone()->get()[0];
        $this->ph = $data['ph'];
        $this->water_flow = $data['water_flow'];
        $this->main_valve = $data['main_valve'];
        $this->time = $data['time'];
    }
}
