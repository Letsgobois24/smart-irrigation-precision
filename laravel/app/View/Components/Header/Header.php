<?php

namespace App\View\Components\Header;

use App\Models\Notification;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.header.header', [
            'count_notifications' => Notification::where('is_active', 1)->count()
        ]);
    }
}
