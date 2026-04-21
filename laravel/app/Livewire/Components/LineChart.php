<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Livewire\Component;

class LineChart extends Component
{
    public string $field;
    public string $table;

    public string $selectedInterval = '1 weeks';
    public string $selectedHour = 'all';

    public $intervals = [
        '1 days' => 'Today',
        '1 weeks' => 'Last Week',
        '2 weeks' => 'Two Weeks Ago',
        '1 months' => 'Last Month'
    ];

    public $hours = [
        'all' => 'All Data',
        0 => '0:00',
        3 => '3:00',
        6 => '6:00',
        9 => '09:00',
        12 => '12:00',
        15 => '15:00',
        18 => '18:00',
        21 => '21:00'
    ];

    public function mount($field, $table)
    {
        $this->field = $field;
        $this->table = $table;
    }

    public function render(InfluxDBService $influx)
    {
        $rawData = $this->getRawData($influx);
        $data = $this->buildSeries($rawData);

        return view('livewire.components.line-chart', [
            'data' => $data
        ]);
    }

    private function getRawData(InfluxDBService $influx)
    {
        $query = '';

        $query = sprintf(
            "SELECT 
                time, 
                %s
            FROM environment
            WHERE time >= now() - INTERVAL '%s' %s
            ORDER BY time",
            $this->field,
            $this->selectedInterval,
            $this->selectedHour !== 'all' ? "AND EXTRACT(HOUR FROM time + INTERVAL '7 hours') = " . $this->selectedHour : ''
        );

        return $influx->query($query)->convertTimezone()->get();
    }

    private function buildSeries($rows)
    {
        $field = $this->field;
        $dateFormat = 'Y-m-d' . ($this->selectedHour === 'all' ? ' H:i' : '');

        return [[
            'name' => $field,
            'data' => $rows->map(function ($row) use ($dateFormat, $field) {
                return [
                    'x' => $row['time']->format($dateFormat),
                    'y' => $row[$field]
                ];
            })->values()
        ]];
    }
}
