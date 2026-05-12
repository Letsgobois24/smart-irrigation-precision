<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Livewire\Component;

class SystemEventTable extends Component
{
    public function render(InfluxDBService $influx)
    {
        $query = $this->systemEventsQuery();
        $result = $influx->query($query)->convertTimezone()->get();

        return view('livewire.components.system-event-table', [
            'events' => $result
        ]);
    }

    private function systemEventsQuery()
    {
        return "SELECT * FROM system_event WHERE node_id=1 ORDER BY time DESC LIMIT 5";
    }
}
