<?php

namespace App\Livewire\Components;

use App\Services\InfluxDBService;
use Livewire\Component;
use Throwable;

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
        'avg' => 'Average',
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
        $data = null;
        $rawData = $this->getRawData($influx);
        dump($rawData);
        // $data = $this->buildSeries($rawData);
        // try {
        // } catch (Throwable $e) {
        //     $this->dispatch('toast', type: 'danger', message: $e->getMessage());
        // }

        return view('livewire.components.line-chart', [
            'data' => $rawData
        ]);
    }

    private function getRawData(InfluxDBService $influx)
    {
        $query = '';

        // if ($this->selectedHour !== 'avg') {
        //     $query = sprintf(
        //         "SELECT 
        //             time, 
        //             %s
        //         FROM environment
        //         WHERE time >= now() - INTERVAL '%s' %s
        //         ORDER BY time",
        //         $this->field,
        //         $this->selectedInterval,
        //         $this->selectedHour !== 'all' ? "AND EXTRACT(HOUR FROM time + INTERVAL '7 hours') = " . $this->selectedHour : ''
        //     );
        // } else {
        //     $query = sprintf(
        //         "SELECT 
        //         date_bin(INTERVAL '1 days', time + INTERVAL '7 hours') AS time, 
        //         %s
        //     FROM environment
        //     WHERE time >= now() - INTERVAL '%s'
        //     GROUP BY time
        //     ORDER BY time",
        //         sprintf("ROUND(AVG(%s), 2) AS %s", $this->field, $this->field),
        //         $this->selectedInterval
        //     );
        // }

        $query = "SELECT
            DATE_BIN(INTERVAL '2 hours', time) AS time,
            selector_max(ph, time)['value'] AS 'max_ph',
            selector_min(ph, time)['value'] AS 'min_ph',
            ROUND(AVG(ph), 2) AS 'avg_ph'
            FROM environment
            GROUP BY 1
            ORDER BY 1";

        return $influx->query($query)
            ->convertTimezone(format: 'Y-m-d H:i')
            ->get();
    }

    private function buildSeries($rows)
    {
        $field = $this->field;
        $dateFormat = 'Y-m-d H:i';

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
