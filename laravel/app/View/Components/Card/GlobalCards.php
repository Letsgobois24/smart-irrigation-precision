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

    public function __construct(
        array $globalData
    ) {
        $this->ph = $globalData['ph'];
        $this->water_flow = $globalData['water_flow'];
        $this->main_valve = $globalData['main_valve'];
        $this->time = $globalData['time'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.global-cards');
    }

    public function phNormal()
    {
        return $this->ph >= 5.5 && $this->ph <= 7.5;
    }

    public function flowNormal()
    {
        return $this->water_flow > 0;
    }
}
