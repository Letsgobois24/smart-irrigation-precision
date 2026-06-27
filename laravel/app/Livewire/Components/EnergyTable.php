<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Carbon\Carbon;
use Livewire\Component;

class EnergyTable extends Component
{
    private string $table = 'energy';

    public int $page = 1;
    public int $paginate = 5;

    public bool $isLast = false;

    public string $start_date = '';
    public string $end_date = '';

    public ?string $selected_source = null;
    public ?string $selected_event = null;

    public array $sources = [
        '' => 'All',
        'PLN' => 'PLN',
        'PLTS' => 'PLTS',
    ];

    public array $events = [
        '' => 'All',
        'periodic' => 'Normal',
        'switching' => 'Switching',
    ];

    public array $date_range;

    public function mount(InfluxDBService $influx)
    {
        $this->date_range = $this->getDateRange($influx);
    }

    public function render(InfluxDBService $influx)
    {
        $data = $this->getData($influx);
        $this->isLast = count($data) < $this->paginate;

        return view('livewire.components.energy-table', compact('data'));
    }

    public function placeholder()
    {
        return view('components.placeholder.event-table-placeholder');
    }

    public function previousPage()
    {
        if ($this->page > 1) {
            $this->page--;
        }
    }

    public function nextPage()
    {
        if (!$this->isLast) {
            $this->page++;
        }
    }

    public function setDateRange()
    {
        $this->reset('page');
    }

    public function showAll()
    {
        $this->reset(
            'page',
            'start_date',
            'end_date',
            'selected_source',
            'selected_event'
        );
    }

    private function getDateRange(InfluxDBService $influx)
    {
        $query = "SELECT time FROM '$this->table' ORDER BY time ASC LIMIT 1";
        $from = $influx->query($query)->get()[0]['time'];

        $query = "SELECT time FROM '$this->table' ORDER BY time DESC LIMIT 1";
        $to = $influx->query($query)->get()[0]['time'];

        return [
            'from' => Carbon::parse($from)->format('Y-m-d'),
            'to' => Carbon::parse($to)->format('Y-m-d'),
        ];
    }

    private function getData(InfluxDBService $influx)
    {
        $offset = ($this->page - 1) * $this->paginate;
        $limit = $this->paginate;

        $query = [
            "SELECT * FROM '$this->table'"
        ];

        if ($where = $this->buildWhereClause()) {
            $query[] = "WHERE $where";
        }

        $query[] = "ORDER BY time DESC";
        $query[] = "OFFSET $offset";
        $query[] = "LIMIT $limit";

        return $influx
            ->query(implode("\n", $query))
            ->convertTimezone()
            ->get();
    }

    private function buildWhereClause(): string
    {
        $conditions = [];

        if ($this->selected_source) {
            $conditions[] = "source='{$this->selected_source}'";
        }

        if ($this->selected_event) {
            $conditions[] = "event='{$this->selected_event}'";
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

    public function getBadgeColor(string $field, float | int $value): string
    {
        return match ($field) {

            'battery_soc' => match (true) {
                $value >= 80 => 'green',
                $value >= 40 => 'yellow',
                default => 'red',
            },

            'battery_voltage' => match (true) {
                $value >= 12.5 => 'green',
                $value >= 11.8 => 'yellow',
                default => 'red',
            },

            'load_current' => match (true) {
                $value < 3 => 'green',
                $value < 6 => 'yellow',
                default => 'red',
            },

            'load_power' => match (true) {
                $value < 300 => 'green',
                $value < 600 => 'yellow',
                default => 'red',
            },

            'pv_voltage' => match (true) {
                $value >= 18 => 'green',
                $value >= 12 => 'yellow',
                default => 'red',
            },

            'pv_current' => match (true) {
                $value >= 2 => 'green',
                $value >= 0.5 => 'yellow',
                default => 'red',
            },

            'pv_power' => match (true) {
                $value >= 50 => 'green',
                $value >= 10 => 'yellow',
                default => 'red',
            },

            default => 'gray',
        };
    }
}
