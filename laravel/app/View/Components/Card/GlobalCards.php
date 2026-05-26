<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GlobalCards extends Component
{
    public float $ph;
    public float $water_flow;
    public bool $main_valve;
    public \Carbon\Carbon $time;
    public bool $flow_normal = false;
    public bool $ph_normal = false;

    public function __construct(
        array $globalData
    ) {
        $this->ph = $globalData['ph'];
        $this->water_flow = $globalData['water_flow'];
        $this->main_valve = $globalData['main_valve'];
        $this->time = $globalData['time'];

        $this->ph_normal = $this->ph >= 5.5 && $this->ph <= 7.5;
        $this->flow_normal = $this->water_flow > 0;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.global-cards');
    }
}
