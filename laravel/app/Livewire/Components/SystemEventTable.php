<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Livewire\Component;

class SystemEventTable extends Component
{
    public int $page = 1;
    public bool $isLast = false;
    public int $paginate = 5;

    public function render(InfluxDBService $influx)
    {
        $events = $this->getEvents($influx);
        $this->isLast = count($events) <= $this->paginate;

        return view('livewire.components.system-event-table', [
            // Tampilkan hanya 5 saja
            'events' => array_slice($events->toArray(), 0, $this->paginate),
            'total_events' => $this->getCountEvents($influx)
        ]);
    }

    public function previousPage()
    {
        $this->page -= 1;
    }

    public function nextPage()
    {
        $this->page += 1;
    }

    private function getEvents(InfluxDBService $influx)
    {
        $offset = ($this->page - 1) * $this->paginate;
        $limit = $this->paginate + 1;
        $query = "SELECT * FROM system_event WHERE node_id=1 ORDER BY time DESC OFFSET $offset LIMIT $limit";

        return $influx->query($query)->convertTimezone()->get();
    }

    private function getCountEvents(InfluxDBService $influx)
    {
        $query = "SELECT COUNT(*) AS total_events FROM system_event WHERE node_id=1";
        return $influx->query($query)->get()[0]['total_events'];
    }
}
