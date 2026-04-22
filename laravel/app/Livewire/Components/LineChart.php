<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Livewire\Component;
use Throwable;

class LineChart extends Component
{
    public string $field;
    public string $table;

    public string $selectedPeriods = '1 days';

    public $periods = [
        '1 hours' => [
            'name' => 'Last Hour',
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
    ];

    public function mount($field, $table)
    {
        $this->field = $field;
        $this->table = $table;
    }

    public function render(InfluxDBService $influx)
    {
        $data = null;
        $rawData = $this->getRawData($influx);
        // dump($rawData);
        // $data = $this->buildSeries($rawData);
        // try {
        // } catch (Throwable $e) {
        //     $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        // }

        return view('livewire.components.line-chart', [
            'data' => $rawData,
            'series_options' => $this->selectedPeriods == '1 hours' ? ['pH'] : ['Max pH', 'Min pH', 'Average pH'],
        ]);
    }

    private function getRawData(InfluxDBService $influx)
    {
        $query = '';

        if ($this->selectedPeriods == '1 hours') {
            $query = "SELECT 
                    time, 
                    {$this->field} AS 'pH'
                FROM {$this->table}
                WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
                ORDER BY time";
        } else {
            $interval = $this->periods[$this->selectedPeriods]['interval'];
            $query = "SELECT
                    DATE_BIN(INTERVAL '{$interval}', time) AS time,
                    selector_max({$this->field}, time)['value'] AS 'Max pH',
                    selector_min({$this->field}, time)['value'] AS 'Min pH',
                    ROUND(AVG({$this->field}), 2) AS 'Average pH'
                FROM {$this->table}
                WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
                GROUP BY 1
                ORDER BY 1";
        }

        return $influx->query($query)
            ->convertTimezone(format: 'Y-m-d H:i')
            ->get();
    }
}
