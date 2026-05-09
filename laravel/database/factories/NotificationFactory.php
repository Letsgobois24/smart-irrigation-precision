<?php

namespace Database\Factories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private $global_sensor = ['pH', 'arus air', 'katup utama', 'arus listrik'];
    private $node_sensor = ['kelembaban tanah', 'katup', 'arus listrik'];

    public function definition(): array
    {
        $source_type = fake()->randomElement(['global', 'pohon']);
        $sensor_type = null;
        if ($source_type == 'pohon') {
            $sensor_type = fake()->randomElement($this->node_sensor);
        } else {
            $sensor_type = fake()->randomElement($this->global_sensor);
        }

        return [
            'title' => fake()->title(),
            'message' => fake()->text(),
            'recomendation' => fake()->text(),
            'source_type' => $source_type,
            'sensor_type' => $sensor_type,
            'severity' => fake()->randomElement(['rendah', 'sedang', 'tinggi']),
            'value' => fake()->randomFloat(2, 0, 100),
            'threshold' => fake()->randomFloat(2, 0, 100),
            'node_id' => $source_type == 'pohon' ? 1 : null,
            'tree_id' => $source_type == 'pohon' ? fake()->numberBetween(1, 4) : null,
            'is_active' => fake()->boolean(80),
            'is_read' => fake()->boolean(80),
        ];
    }
}
