<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Home extends Component
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

        return view('livewire.pages.home', [
            'node_data' => $node_data
        ]);
    }
}
