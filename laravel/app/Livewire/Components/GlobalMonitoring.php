<?php

namespace App\Livewire\Components;

use App\Services\InfluxService;
use Livewire\Component;

class GlobalMonitoring extends Component
{
    public int $ph;
    public float $water_flow;
    public bool $main_valve;
    public $time;

    public function mount(InfluxService $influxService)
    {
        $data = $influxService->query("SELECT * FROM 'environment' ORDER BY TIME DESC LIMIT 1")[0];
        $this->water_flow = $data['water_flow'];
        $this->main_valve = $data['main_valve'];
        $this->time = $data['time'];
    }

    public function render()
    {
        return view('livewire.components.global-monitoring');
    }

    public function getDataNow(InfluxService $influxService)
    {
        $data = $influxService->query("SELECT * FROM 'environment' ORDER BY TIME DESC LIMIT 1");
        dump($data[0]);
        $this->dispatch('toast', type: 'success', message: 'Data has been updated');
    }
}
