<?php

namespace App\View\Components\Header;

use App\Models\Configuration;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{

    /**
     * Get the view / contents that represent the component.
     */
    public int $now;

    public function __construct()
    {
        $this->now = now()->valueOf();
    }

    public function render(): View|Closure|string
    {
        return view('components.header.header');
    }
}
