<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Livewire\Component;

class SystemEventTable extends Component
{
    public int $page = 1;
    public bool $isLast = false;
    private int $paginate = 5;

    public function render(InfluxDBService $influx)
    {
        $query = $this->systemEventsQuery();
        $result = $influx->query($query)->convertTimezone()->get();

        $this->isLast = count($result) <= $this->paginate;

        return view('livewire.components.system-event-table', [
            // Tampilkan hanya 5 saja
            'events' => array_slice($result->toArray(), 0, $this->paginate)
        ]);
    }

    public function previousPage()
    {
        $this->page -= 1;
    }

    public function nextPage(InfluxDBService $influx)
    {
        $this->page += 1;
    }

    private function systemEventsQuery()
    {
        $offset = ($this->page - 1) * $this->paginate;
        $limit = $this->paginate + 1;
        return "SELECT * FROM system_event WHERE node_id=1 ORDER BY time DESC OFFSET $offset LIMIT $limit";
    }
}
