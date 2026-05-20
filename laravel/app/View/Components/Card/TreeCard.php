<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TreeCard extends Component
{
    /**
     * Kondisi smart irrigation alpukat
     * < 30   = Kering / Critical
     * 30-70  = Normal
     * > 70   = Terlalu basah
     */

    public bool $isDry;
    public bool $isWet;
    public bool $isNormal;

    public function __construct(
        public array $tree,
    ) {
        $moisture = $tree['soil_moisture'];

        $this->isDry = $moisture < 30;
        $this->isWet = $moisture > 70;
        $this->isNormal = !$this->isDry && !$this->isWet;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.tree-card');
    }

    public function cardClass()
    {
        return match (true) {
            $this->isDry => 'bg-red-50 border border-red-200',
            $this->isWet => 'bg-yellow-50 border border-yellow-200',
            default => 'bg-green-50 border border-green-200',
        };
    }

    public function badgeColor()
    {
        return match (true) {
            $this->isDry => 'red',
            $this->isWet => 'yellow',
            default => 'green',
        };
    }

    public function statusText()
    {
        return match (true) {
            $this->isDry => 'Soil Dry',
            $this->isWet => 'Too Wet',
            default => 'Optimal',
        };
    }
}
