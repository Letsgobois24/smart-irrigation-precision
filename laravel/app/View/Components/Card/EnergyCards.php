<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EnergyCards extends Component
{
    public array $source_config = [];
    public array $energy_cards = [];
    public string $is_switching = '';

    public function __construct(
        public array $energyData
    ) {
        $this->is_switching = $energyData['event'] == 'switching';
        $this->source_config = $this->getSourceConfig();
        $this->energy_cards = $this->getEnergyCards();
    }

    public function render(): View|Closure|string
    {
        return view('components.card.energy-cards');
    }

    private function getSourceConfig(): array
    {
        $activeSource = strtoupper($this->energyData['source']);
        return match ($activeSource) {
            'PLTS' => [
                'icon' => '☀️',
                'title' => 'PLTS',
                'bg' => 'bg-green-50',
                'border' => 'border-green-300',
            ],

            'PLN' => [
                'icon' => '⚡',
                'title' => 'PLN',
                'bg' => 'bg-blue-50',
                'border' => 'border-blue-300',
            ],

            default => [
                'icon' => '❓',
                'title' => 'Unknown',
                'bg' => 'bg-gray-50',
                'border' => 'border-gray-300',
            ]
        };
    }

    private function getEnergyCards(): array
    {
        return [
            [
                'title' => 'Battery',
                'icon' => '🔋',
                'border' => 'border-yellow-200',

                'value' => $this->energyData['battery_soc'] . '%',
                'valueClass' => $this->thresholdColor(
                    'battery_soc',
                    $this->energyData['battery_soc']
                ),

                'details' => [
                    [
                        'text' => $this->energyData['battery_voltage'] . ' V',
                        'class' => $this->thresholdColor(
                            'battery_voltage',
                            $this->energyData['battery_voltage']
                        ),
                    ],
                ],

                'progress' => $this->energyData['battery_soc'],
                'progressColor' => $this->batteryColor(),
            ],

            [
                'title' => 'Solar Panel',
                'icon' => '☀️',
                'border' => 'border-orange-200',

                'value' => $this->energyData['pv_power'] . ' W',
                'valueClass' => $this->thresholdColor(
                    'pv_power',
                    $this->energyData['pv_power']
                ),

                'details' => [
                    [
                        'text' => $this->energyData['pv_voltage'] . ' V',
                        'class' => $this->thresholdColor(
                            'pv_voltage',
                            $this->energyData['pv_voltage']
                        ),
                    ],
                    [
                        'text' => '•',
                        'class' => 'text-gray-400',
                    ],
                    [
                        'text' => $this->energyData['pv_current'] . ' A',
                        'class' => $this->thresholdColor(
                            'pv_current',
                            $this->energyData['pv_current']
                        ),
                    ],
                ],

                'progress' => null,
            ],

            [
                'title' => 'Load',
                'icon' => '💡',
                'border' => 'border-green-200',

                'value' => $this->energyData['load_power'] . ' W',
                'valueClass' => $this->thresholdColor(
                    'load_power',
                    $this->energyData['load_power']
                ),

                'details' => [
                    [
                        'text' => $this->energyData['load_current'] . ' A',
                        'class' => $this->thresholdColor(
                            'load_current',
                            $this->energyData['load_current']
                        ),
                    ],
                ],

                'progress' => null,
            ],
        ];
    }

    private function thresholdColor(string $field, float|int $value): string
    {
        $color = match ($field) {
            'battery_soc' => match (true) {
                $value >= 80 => 'green',
                $value >= 40 => 'yellow',
                default => 'red',
            },

            'battery_voltage' => match (true) {
                $value >= 12.5 => 'green',
                $value >= 11.8 => 'yellow',
                default => 'red',
            },

            'load_current' => match (true) {
                $value < 3 => 'green',
                $value < 6 => 'yellow',
                default => 'red',
            },

            'load_power' => match (true) {
                $value < 300 => 'green',
                $value < 600 => 'yellow',
                default => 'red',
            },

            'pv_voltage' => match (true) {
                $value >= 18 => 'green',
                $value >= 12 => 'yellow',
                default => 'red',
            },

            'pv_current' => match (true) {
                $value >= 2 => 'green',
                $value >= 0.5 => 'yellow',
                default => 'red',
            },

            'pv_power' => match (true) {
                $value >= 50 => 'green',
                $value >= 10 => 'yellow',
                default => 'red',
            },

            default => 'gray',
        };

        return match ($color) {
            'green' => 'text-green-600',
            'yellow' => 'text-yellow-600',
            'red' => 'text-red-600',
            default => 'text-gray-900',
        };
    }

    private function batteryColor(): string
    {
        $soc = $this->energyData['battery_soc'];
        return match (true) {
            $soc >= 80 => 'bg-green-500',
            $soc >= 40 => 'bg-yellow-500',
            default => 'bg-red-500',
        };
    }
}
