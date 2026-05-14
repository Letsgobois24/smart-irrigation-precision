<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Carbon\Carbon;
use Livewire\Component;

class SystemEventTable extends Component
{
    public int $page = 1;
    public int $paginate = 5;

    public bool $isLast = false;

    public string $startDate = '';
    public string $endDate = '';

    public array $enableDateRange;
    public int $total_events;

    public function mount(InfluxDBService $influx)
    {
        $query = "SELECT time FROM system_event ORDER BY time ASC LIMIT 1";
        $from = $influx->query($query)->get()[0]['time'];

        $query = "SELECT time FROM system_event ORDER BY time DESC LIMIT 1";
        $to = $influx->query($query)->get()[0]['time'];

        $this->enableDateRange = [
            'from' => Carbon::parse($from)->format('Y-m-d'),
            'to' => Carbon::parse($to)->format('Y-m-d')
        ];

        $this->total_events = $this->getCountEvents($influx);
    }

    public function render(InfluxDBService $influx)
    {
        $events = $this->getEvents($influx);
        $this->isLast = ($this->page - 1) * $this->paginate + count($events) == $this->total_events;

        return view('livewire.components.system-event-table', [
            'events' => $events,
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

    public function applyDateRange(InfluxDBService $influx)
    {
        $this->page = 1;
        $this->total_events = $this->getCountEvents($influx);
    }

    private function getEvents(InfluxDBService $influx)
    {
        $offset = ($this->page - 1) * $this->paginate;
        $limit = $this->paginate;

        $where = $this->buildWhereClause();

        $query = "
            SELECT *
            FROM system_event
            WHERE $where
            ORDER BY time DESC
            OFFSET $offset
            LIMIT $limit
        ";

        return $influx->query($query)->convertTimezone()->get();
    }

    private function getCountEvents(InfluxDBService $influx)
    {
        $where = $this->buildWhereClause();

        $query = "
            SELECT COUNT(*) AS total_events
            FROM system_event
            WHERE $where
        ";

        return $influx->query($query)->get()[0]['total_events'];
    }

    private function buildWhereClause(): string
    {
        $conditions = [
            "node_id=1"
        ];

        if ($this->startDate && $this->endDate) {
            $startDateZulu = Carbon::parse($this->startDate)
                ->startOfDay()
                ->toIso8601ZuluString();

            $endDateZulu = Carbon::parse($this->endDate)
                ->addDay()
                ->startOfDay()
                ->toIso8601ZuluString();

            $conditions[] = "time >= '$startDateZulu'";
            $conditions[] = "time < '$endDateZulu'";
        }

        return implode(' AND ', $conditions);
    }
}
