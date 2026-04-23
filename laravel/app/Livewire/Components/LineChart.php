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

    public function mount($field, $fieldName, $table)
    {
        $this->fieldName = $fieldName;
        $this->field = $field;
        $this->table = $table;
    }

    public function render(InfluxDBService $influx)
    {
        $data = null;
        try {
            $this->sanitize();
            $data = $this->getRawData($influx);
        } catch (Throwable $e) {
            $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        }

        return view('livewire.components.line-chart', [
            'data' => $data,
            'series_options' => $this->getSeriesOption(),
        ]);
    }

    private function getSeriesOption()
    {
        if ($this->selectedPeriods == '2 hours') {
            return [$this->fieldName];
        }
        return ["Max {$this->fieldName}", "Min {$this->fieldName}", "Average {$this->fieldName}"];
    }

    private function getRawData(InfluxDBService $influx)
    {
        $query = '';

        if ($this->selectedPeriods == '2 hours') {
            $query = "SELECT 
                    time, 
                    {$this->field} AS '{$this->fieldName}'
                FROM {$this->table}
                WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
                ORDER BY time";
        } else {
            $interval = $this->periods[$this->selectedPeriods]['interval'];
            $query = "SELECT
                    DATE_BIN(INTERVAL '{$interval}', time) AS time,
                    selector_max({$this->field}, time)['value'] AS 'Max {$this->fieldName}',
                    selector_min({$this->field}, time)['value'] AS 'Min {$this->fieldName}',
                    ROUND(AVG({$this->field}), 2) AS 'Average {$this->fieldName}'
                FROM {$this->table}
                WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
                GROUP BY 1
                ORDER BY 1";
        }

        return $influx->query($query)
            ->convertTimezone(format: 'Y-m-d H:i')
            ->get();
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
