<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Exception;
use Livewire\Component;
use Throwable;

class LineChart extends Component
{
    public string $field;
    public string $fieldName;
    public string $table;
    public string $groupby;

    public string $selectedPeriods = '2 hours';

    public $periods = [
        '2 hours' => [
            'name' => 'Last 2 Hours',
        ],
        '6 hours' => [
            'name' => 'Last 6 Hours',
            'interval' => '15 minutes'
        ],
        '1 days' => [
            'name' => 'Last Day',
            'interval' => '1 hours'
        ],
        '1 weeks' => [
            'name' => 'Last Week',
            'interval' => '6 hours'
        ],
        '1 months' => [
            'name' => 'Last Month',
            'interval' => '1 days'
        ],
    ];

    public function mount($field, $fieldName, $table, $groupby = '')
    {
        $this->fieldName = $fieldName;
        $this->field = $field;
        $this->table = $table;
        $this->groupby = $groupby;
    }

    public function render(InfluxDBService $influx)
    {
        $data = [];
        try {
            $data = $this->getRawData($influx);
            $this->sanitize();
            if (count($data) == 0) {
                throw new Exception("No data available in {$this->fieldName} chart");
            }
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }

        return view('livewire.components.line-chart', [
            'data' => $data,
            'series_options' => $this->getSeriesOption($data[0] ?? null),
        ]);
    }

    public function placeholder()
    {
        return view('components.placeholder.line-chart-placeholder');
    }

    private function getSeriesOption($data)
    {
        if (!$data) {
            return null;
        }
        $seriesName = array_keys($data);
        array_splice($seriesName, 0, 1);
        return $seriesName;
    }

    private function getRawData(InfluxDBService $influx)
    {
        $query = '';

        if ($this->selectedPeriods == '2 hours') {
            $query = $this->singleLineQuery();
        } elseif ($this->groupby) {
            $query = $this->groupByQuery();
        } else {
            $query = $this->aggregateLineQuery();
        }

        $result = $influx->query($query);
        if ($this->groupby) {
            $result->groupBySeries($this->groupby, $this->fieldName, addAverage: true);
        }
        return $result->convertTimezone()->get();
    }

    private function singleLineQuery()
    {
        $groupByField = $this->groupby ? ',' . $this->groupby : '';
        return "SELECT 
            time, 
            {$this->field} AS '{$this->fieldName}' {$groupByField}
        FROM {$this->table}
        WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
        ORDER BY time";
    }

    private function aggregateLineQuery()
    {
        $interval = $this->periods[$this->selectedPeriods]['interval'];
        return "SELECT
                    DATE_BIN(INTERVAL '{$interval}', time) AS time,
                    selector_max({$this->field}, time)['value'] AS 'Max {$this->fieldName}',
                    selector_min({$this->field}, time)['value'] AS 'Min {$this->fieldName}',
                    ROUND(AVG({$this->field}), 2) AS 'Average {$this->fieldName}'
                FROM {$this->table}
                WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
                GROUP BY 1
                ORDER BY 1";
    }

    private function groupByQuery()
    {
        $interval = $this->periods[$this->selectedPeriods]['interval'];
        return "SELECT
                    DATE_BIN(INTERVAL '{$interval}', time) AS time,
                    {$this->groupby},
                    ROUND(AVG({$this->field}), 2) AS '{$this->fieldName}'
                FROM {$this->table}
                WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
                GROUP BY 1, {$this->groupby}
                ORDER BY time, {$this->groupby}";
    }

    private array $allowedFields = ['ph', 'water_flow', 'soil_moisture'];
    private array $allowedTables = ['environment', 'node'];
    private function sanitize()
    {
        if (!in_array($this->field, $this->allowedFields)) {
            throw new Exception('Invalid field');
        }

        if (!in_array($this->table, $this->allowedTables)) {
            throw new Exception('Invalid table');
        }
    }
}
