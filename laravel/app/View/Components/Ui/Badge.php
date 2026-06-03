<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public function __construct(
        private string $color = 'gray',
        private string $size = 'sm',
        public string $class = ''
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.ui.badge');
    }

    public function sizeClass(): string
    {
        return match ($this->size) {
            'xs' => 'text-[10px] px-1.5 py-0.5 rounded-md font-medium',
            'sm' => 'text-xs px-2 py-1 rounded-full font-medium',
            'md' => 'text-sm px-3 py-1 rounded-full font-medium',
            'lg' => 'text-base px-4 py-1.5 rounded-full font-semibold',
            default => 'text-xs px-2 py-1 rounded-full font-medium',
        };
    }

    public function colorClass(): string
    {
        return match ($this->color) {
            'gray' => 'bg-gray-100 text-gray-700',
            'green' => 'bg-green-100 text-green-700',
            'red' => 'bg-red-100 text-red-700',
            'yellow' => 'bg-yellow-100 text-yellow-700',
            'blue' => 'bg-blue-100 text-blue-700',
            'purple' => 'bg-purple-100 text-purple-700',
            'emerald' => 'bg-emerald-100 text-emerald-700',
            'sky' => 'bg-sky-100 text-sky-700',
            'slate' => 'bg-slate-200 text-slate-800',
            'amber' => 'bg-amber-100 text-amber-700',
            'orange' => 'bg-orange-100 text-orange-700',
            default => '',
        };
    }
}
