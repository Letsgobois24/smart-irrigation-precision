<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Illuminate\Support\Collection;
use Livewire\Component;

class MultiLineChart extends Component
{
    public string $field = '';
    public string $fieldName = '';
    public string $table = '';
    public string $groupby = '';
    public string $ylabel = '';
    public string $xlabel = '';

    public string $selectedPeriods = '2 hours';

    public array $periods = [
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

    public function render(InfluxDBService $influx)
    {
        $data = $this->getRawData($influx);
        $data = $this->seriesData($data);

        return view('livewire.components.multi-line-chart', compact('data'));
    }

    public function placeholder()
    {
        return view('components.placeholder.line-chart-placeholder');
    }

    private function seriesData(Collection $data)
    {
        return $data->groupBy($this->groupby)
            ->map(function ($rows, $groupValue) {
                return [
                    'name' => "{$this->xlabel} {$groupValue}",
                    'data' => $rows->map(function ($row) {
                        return [
                            $row['time']->timestamp * 1000,
                            $row['soil_moisture']
                        ];
                    })->values()
                ];
            })
            ->values();
    }

    private function getRawData(InfluxDBService $influx)
    {

        if ($this->selectedPeriods == '2 hours') {
            $query = "SELECT time,
                    {$this->groupby},
                    soil_moisture
                FROM {$this->table}
                WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
                ORDER BY {$this->groupby}, time";
        } else {
            $interval = $this->periods[$this->selectedPeriods]['interval'];
            $query = "SELECT
                    DATE_BIN(INTERVAL '{$interval}', time) AS time,
                    {$this->groupby},
                    ROUND(AVG({$this->field}), 2) AS 'soil_moisture'
                FROM {$this->table}
                WHERE time >= now() - INTERVAL '{$this->selectedPeriods}'
                GROUP BY 1, {$this->groupby}
                ORDER BY time, {$this->groupby}";
        }

        $result = $influx->query($query)->convertTimezone();
        return $result->get();
    }
}
