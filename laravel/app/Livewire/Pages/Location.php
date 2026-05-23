<?php

namespace App\Livewire\Pages;

use App\Models\Tree;
use App\Services\InfluxDBService;
use Livewire\Component;

class Location extends Component
{
    public int $max_col = 0;

    public function mount()
    {
        $this->max_col = Tree::max('col_idx');
    }

    public function render(InfluxDBService $influx)
    {
        $trees = Tree::all();

        $active_trees_id = $this->getActiveTreeId($trees);
        $sensors = $this->getSensorData($influx, $active_trees_id);
        $trees = $this->combineSensorTree($trees, $sensors);

        return view('livewire.pages.location', [
            'trees' => $trees
        ]);
    }

    private function getActiveTreeId(object $trees)
    {
        $active_trees_id = [];
        foreach ($trees as $tree) {
            if ($tree['is_active'] == 1) {
                $active_trees_id[] = $tree['tree_id'];
            }
        }
        return $active_trees_id;
    }

    private function combineSensorTree(object $trees, object $sensors)
    {
        $sensorsByTreeId = collect($sensors)->keyBy('tree_id');

        return $trees->map(function ($tree) use ($sensorsByTreeId) {
            $sensor = $sensorsByTreeId[$tree['tree_id']] ?? null;

            return [
                ...$tree->toArray(),
                'soil_moisture' => $sensor['soil_moisture'] ?? null,
                'valve' => $sensor['valve'] ?? null,
                'time' => $sensor['time'] ?? null,
            ];
        });
    }

    private function getSensorData(InfluxDBService $influx, array $searched_trees_id)
    {
        $searched_trees_id = implode(',', $searched_trees_id);

        $query = "SELECT 
            DISTINCT ON (tree_id) * FROM node
            WHERE tree_id IN ($searched_trees_id)
            ORDER BY tree_id, time DESC;";

        return $influx->query($query)->convertTimezone()->get();
    }
}
