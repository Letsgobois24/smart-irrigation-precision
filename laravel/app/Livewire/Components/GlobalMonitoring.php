<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
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
        return view('livewire.components.global-monitoring', [
            'now' => now()->millisecond()
        ]);
    }

    public function refresh(InfluxDBService $influx)
    {
        try {
            $this->update($influx);
            $this->dispatch('toast', type: 'success', message: 'Global data has been updated');
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }
    }

    private function update(InfluxDBService $influx)
    {
        $query = "SELECT * 
                FROM 'environment' 
                WHERE time <= now()
                ORDER BY TIME DESC 
                LIMIT 1";
        $data = $influx->query($query)->convertTimezone()->get()[0];
        $this->water_flow = $data['water_flow'];
        $this->main_valve = $data['main_valve'];
        $this->time = $data['time'];
    }
}
