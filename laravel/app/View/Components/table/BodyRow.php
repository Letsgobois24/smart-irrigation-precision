<?php

namespace App\View\Components\Table;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BodyRow extends Component
{
    public float $currentDelta;
    public bool $isAnomaly;

    public function __construct(
        public array $row
    ) {
        $this->currentDelta = $row['current_delta'];
        $this->isAnomaly = $row['anomaly_flag'];
    }

    public function render(): View|Closure|string
    {
        return view('components.table.body-row');
    }
}
