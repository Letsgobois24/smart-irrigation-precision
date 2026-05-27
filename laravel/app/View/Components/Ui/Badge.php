<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    /**
     * Create a new component instance.
     */

    // yellow, red, green
    public function __construct(
        private string $color,
        private string $size = '1',
        public string $class = ''
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.badge');
    }

    public function textClass()
    {
        return match ($this->size) {
            '1' => 'text-[10px] font-medium',
            '2' => 'text-xs font-semibold',
            '3' => 'text-sm font-bold',
        };
    }

    public function badgeClass()
    {
        return match ($this->color) {
            'gray' => 'bg-gray-200 text-gray-700',
            'green' => 'bg-green-100 text-green-700',
            'red' => 'bg-red-100 text-red-700',
            'yellow' => 'bg-yellow-100 text-yellow-700',
            'blue' => 'bg-blue-100 text-blue-700',
            'purple' => 'bg-purple-100 text-purple-700',
            'emerald' => 'bg-emerald-100 text-emerald-700',
            'sky' => 'bg-sky-100 text-sky-700',
            default => ''
        };
    }
}
