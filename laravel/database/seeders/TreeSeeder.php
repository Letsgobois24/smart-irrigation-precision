<?php

namespace Database\Seeders;

use App\Models\Tree;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Node ID: 2
        Tree::create([
            'tree_id' => 1,
            'node_id' => 2,
            'variant' => 'miki',
            'row_idx' => 1,
            'col_idx' => 1,
            'latitude' => -7.047550,
            'longitude' => 110.435080
        ]);
        Tree::create([
            'tree_id' => 2,
            'node_id' => 2,
            'variant' => 'miki',
            'row_idx' => 1,
            'col_idx' => 2,
            'latitude' => -7.04753,
            'longitude' => 110.435138
        ]);

        // Node ID: 1
        Tree::create([
            'tree_id' => 3,
            'node_id' => 1,
            'variant' => 'miki',
            'row_idx' => 2,
            'col_idx' => 1,
            'is_active' => 1,
            'latitude' => -7.047407,
            'longitude' => 110.435154
        ]);
        Tree::create([
            'tree_id' => 4,
            'node_id' => 1,
            'variant' => 'miki',
            'row_idx' => 2,
            'col_idx' => 2,
            'is_active' => 1,
            'latitude' => -7.047464,
            'longitude' => 110.435152
        ]);
        Tree::create([
            'tree_id' => 5,
            'node_id' => 1,
            'variant' => 'miki',
            'row_idx' => 3,
            'col_idx' => 1,
            'is_active' => 1,
            'latitude' => -7.047435,
            'longitude' => 110.435182
        ]);
        Tree::create([
            'tree_id' => 6,
            'node_id' => 1,
            'variant' => 'miki',
            'row_idx' => 3,
            'col_idx' => 2,
            'is_active' => 1,
            'latitude' => -7.047451,
            'longitude' => 110.435183
        ]);

        // Node ID: 3
        Tree::create([
            'tree_id' => 7,
            'node_id' => 3,
            'variant' => 'miki',
            'row_idx' => 4,
            'col_idx' => 1,
            'latitude' => -7.047313,
            'longitude' => 110.435178
        ]);
        Tree::create([
            'tree_id' => 8,
            'node_id' => 3,
            'variant' => 'miki',
            'row_idx' => 4,
            'col_idx' => 2,
            'latitude' => -7.047367,
            'longitude' => 110.435211
        ]);
        Tree::create([
            'tree_id' => 9,
            'node_id' => 3,
            'variant' => 'miki',
            'row_idx' => 5,
            'col_idx' => 1,
            'latitude' => -7.047363,
            'longitude' => 110.435223
        ]);
        Tree::create([
            'tree_id' => 10,
            'node_id' => 3,
            'variant' => 'miki',
            'row_idx' => 5,
            'col_idx' => 2,
            'latitude' => -7.047355,
            'longitude' => 110.435213
        ]);
    }
}
