<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MoistureCell extends Component
{
    public string $status;

    public function __construct(
        public int $value
    ) {
        $this->status = $this->getMoistureStatus($value);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.moisture-cell');
    }

    private function getMoistureStatus(float $value): string
    {
        return match (true) {
            $value < 30 => 'dry',
            $value > 70 => 'wet',
            default => 'normal',
        };
    }

    public function badgeColor(): string
    {
        return match ($this->status) {
            'dry' => 'yellow',
            'wet' => 'blue',
            default => 'green',
        };
    }

    public function barColor(): string
    {
        return match ($this->status) {
            'dry' => 'bg-orange-500',
            'wet' => 'bg-blue-500',
            default => 'bg-green-500',
        };
    }
}
