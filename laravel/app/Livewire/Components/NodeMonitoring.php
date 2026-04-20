<?php

namespace App\Livewire\Components;

use Livewire\Component;

class NodeMonitoring extends Component
{
    public function render()
    {
        $node_data = [
            [
                "soil_moisture" => 40.1,
                "tree_id" => 1,
                "valve" => 1
            ],
            [
                "soil_moisture" => 42.3,
                "tree_id" => 2,
                "valve" => 0
            ],
            [
                "soil_moisture" => 39.8,
                "tree_id" => 3,
                "valve" => 1
            ],
            [
                "soil_moisture" => 41,
                "tree_id" => 4,
                "valve" => 0
            ]
        ];

        return view('livewire.components.node-monitoring', [
            'node_data' => $node_data
        ]);
    }
}
