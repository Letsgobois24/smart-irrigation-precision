<?php

namespace App\Livewire\Pages;

use App\Models\Tree;
use Livewire\Component;

class Location extends Component
{
    public function render()
    {
        $trees = Tree::all();

        return view('livewire.pages.location', [
            'trees' => $trees
        ]);
    }
}
