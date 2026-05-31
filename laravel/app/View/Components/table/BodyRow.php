<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BodyRow extends Component
{
    public float $currentDelta;
    public bool $isAnomaly;

    public float $moistureBefore;
    public float $moistureAfter;

    public string $beforeStatus;
    public string $afterStatus;

    public function __construct(
        public array $row
    ) {
        $this->currentDelta = $row['current_delta'];

        $this->isAnomaly = $row['anomaly_flag'];

        $this->moistureBefore = $row['moisture_before'];
        $this->moistureAfter = $row['moisture_after'];

        $this->beforeStatus = $this->getMoistureStatus($row['moisture_before']);
        $this->afterStatus = $this->getMoistureStatus($row['moisture_after']);
    }

    public function render(): View|Closure|string
    {
        return view('components.table.body-row');
    }

    private function getMoistureStatus(float $value): string
    {
        return match (true) {
            $value < 30 => 'dry',
            $value > 70 => 'wet',
            default => 'normal',
        };
    }

    public function moistureColor(string $status): string
    {
        return match ($status) {
            'dry' => 'yellow',
            'wet' => 'blue',
            default => 'green',
        };
    }

    public function moistureBarColor(string $status): string
    {
        return match ($status) {
            'dry' => 'bg-orange-500',
            'wet' => 'bg-blue-500',
            default => 'bg-green-500',
        };
    }
}
