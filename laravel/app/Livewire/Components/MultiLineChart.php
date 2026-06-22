<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use App\Livewire\Components\BaseLineChart;
use Illuminate\Support\Collection;

class MultiLineChart extends BaseLineChart
{
    public function render(InfluxDBService $influx)
    {
        $data = $this->getRawData($influx);
        $data = $this->seriesData($data);

        return view('livewire.components.multi-line-chart', compact('data'));
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
