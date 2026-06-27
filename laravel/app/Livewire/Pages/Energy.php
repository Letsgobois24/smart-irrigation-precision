<?php

namespace App\Livewire\Pages;

use App\Services\InfluxDBService;
use Livewire\Component;

class Energy extends Component
{
    public bool $refresh_child = true;

    public function render()
    {
        $energy_data = $this->getEnergyLatest(app(InfluxDBService::class));
        return view('livewire.pages.energy', compact('energy_data'));
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
