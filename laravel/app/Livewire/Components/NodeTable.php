<?php

namespace App\Livewire\Components;

use App\Models\Tree;
use App\Services\InfluxDBService;
use App\Services\TreeServices;
use Carbon\Carbon;
use Livewire\Component;

class NodeTable extends Component
{
    private string $table = 'node';

    public int $page = 1;
    public int $paginate = 5;

    public bool $isLast = false;

    public string $start_date = '';
    public string $end_date = '';
    public null | int $selected_tree = null;
    public string $selected_event = '';

    public array $event_sources = [
        '' => 'All',
        'periodic' => 'Periodic',
        'event' => 'Event'
    ];
    public array $date_range;
    public array $trees_id = [];

    public int $total_rows;

    public function mount(InfluxDBService $influx,)
    {
        // Get option for Tree Id
        $this->trees_id = Tree::getOptions(node_id: 1);
        $this->date_range = $this->getDateRange($influx);
    }

    public function render(InfluxDBService $influx)
    {
        $data = $this->getData($influx);
        $this->isLast = count($data) < $this->paginate;

        return view('livewire.components.node-table', compact('data'));
    }

    public function placeholder()
    {
        return view('components.placeholder.event-table-placeholder');
    }

    public function previousPage()
    {
        $this->page -= 1;
    }

    public function nextPage()
    {
        $this->page += 1;
    }

    public function setDateRange()
    {
        $this->reset('page');
    }

    public function showAll()
    {
        $this->reset('page', 'start_date', 'end_date', 'selected_tree');
    }

    private function getDateRange(InfluxDBService $influx)
    {
        $query = "SELECT time FROM '$this->table' ORDER BY time ASC LIMIT 1";
        $from = $influx->query($query)->get()[0]['time'];

        $query = "SELECT time FROM '$this->table' ORDER BY time DESC LIMIT 1";
        $to = $influx->query($query)->get()[0]['time'];

        return [
            'from' => Carbon::parse($from)->format('Y-m-d'),
            'to' => Carbon::parse($to)->format('Y-m-d')
        ];
    }

    private function getData(InfluxDBService $influx)
    {
        $offset = ($this->page - 1) * $this->paginate;
        $limit = $this->paginate;

        $query = ["SELECT * FROM '$this->table'"];

        if ($where = $this->buildWhereClause()) {
            $query[] = "WHERE $where";
        }

        $query[] = "ORDER BY time DESC";
        $query[] = "OFFSET $offset";
        $query[] = "LIMIT $limit";

        return $influx->query(implode("\n", $query))
            ->convertTimezone()
            ->get();
    }

    private function buildWhereClause(): string
    {
        $conditions = ["node_id=1"];

        // Location Filter
        if ($this->selected_tree) {
            $conditions[] = "tree_id='$this->selected_tree'";
        }

        // Source Event Filter
        if ($this->selected_event) {
            $conditions[] = "event_source='$this->selected_event'";
        }

        if ($this->start_date && $this->end_date) {
            $startDateZulu = Carbon::parse($this->start_date)
                ->startOfDay()
                ->toIso8601ZuluString();

            $endDateZulu = Carbon::parse($this->end_date)
                ->addDay()
                ->startOfDay()
                ->toIso8601ZuluString();

            $conditions[] = "time >= '$startDateZulu'";
            $conditions[] = "time < '$endDateZulu'";
        }

        return implode(' AND ', $conditions);
    }
}
