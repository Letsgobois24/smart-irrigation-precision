<?php

namespace App\Livewire\Pages;

use App\Models\Tree;
use App\Services\GlobalServices;
use App\Services\NodeServices;
use Livewire\Component;

class Dashboard extends Component
{
    private $trees = [];

    public function mount()
    {
        $this->trees = Tree::getTreeId(1)->toArray();
    }

    public function render(GlobalServices $globalServices, NodeServices $nodeServices)
    {
        $global_data = $globalServices->latest();
        $node_data = $nodeServices->latest($this->trees);

        return view(
            'livewire.pages.dashboard',
            compact('global_data', 'node_data')
        );
    }
}
