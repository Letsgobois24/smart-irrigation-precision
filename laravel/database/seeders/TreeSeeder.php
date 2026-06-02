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
        // $total_rows = 5;
        // $total_cols = 2;

        // Node ID: 2
        Tree::create([
            'tree_id' => 1,
            'node_id' => 2,
            'variant' => 'miki',
            'row_idx' => 1,
            'col_idx' => 1,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);
        Tree::create([
            'tree_id' => 2,
            'node_id' => 2,
            'variant' => 'miki',
            'row_idx' => 1,
            'col_idx' => 2,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);

        // Node ID: 1
        Tree::create([
            'tree_id' => 3,
            'node_id' => 1,
            'variant' => 'miki',
            'row_idx' => 2,
            'col_idx' => 1,
            'is_active' => 1,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);
        Tree::create([
            'tree_id' => 4,
            'node_id' => 1,
            'variant' => 'miki',
            'row_idx' => 2,
            'col_idx' => 2,
            'is_active' => 1,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);
        Tree::create([
            'tree_id' => 5,
            'node_id' => 1,
            'variant' => 'miki',
            'row_idx' => 3,
            'col_idx' => 1,
            'is_active' => 1,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);
        Tree::create([
            'tree_id' => 6,
            'node_id' => 1,
            'variant' => 'miki',
            'row_idx' => 3,
            'col_idx' => 2,
            'is_active' => 1,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);

        // Node ID: 3
        Tree::create([
            'tree_id' => 7,
            'node_id' => 3,
            'variant' => 'miki',
            'row_idx' => 4,
            'col_idx' => 1,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);
        Tree::create([
            'tree_id' => 8,
            'node_id' => 3,
            'variant' => 'miki',
            'row_idx' => 4,
            'col_idx' => 2,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);
        Tree::create([
            'tree_id' => 9,
            'node_id' => 3,
            'variant' => 'miki',
            'row_idx' => 5,
            'col_idx' => 1,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);
        Tree::create([
            'tree_id' => 10,
            'node_id' => 3,
            'variant' => 'miki',
            'row_idx' => 5,
            'col_idx' => 2,
            'latitude' => -7.048015017907472,
            'longitude' => 110.43501626001367
        ]);
    }
}
