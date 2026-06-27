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
        $this->is_switching = filter_var(
            $this->energyData['switch_status'],
            FILTER_VALIDATE_BOOLEAN
        ) ? 'ON' : 'OFF';
        $this->source_config = $this->getSourceConfig();
        $this->energy_cards = $this->getEnergyCards();
    }

    private function getSourceConfig(): array
    {
        $activeSource = strtoupper($this->energyData['active_source']);
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

            'BATTERY' => [
                'icon' => '🔋',
                'title' => 'Battery',
                'bg' => 'bg-yellow-50',
                'border' => 'border-yellow-300',
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
                'subtitle' => $this->energyData['battery_voltage'] . ' V',
                'valueClass' => 'text-gray-900',
                'progress' => $this->energyData['battery_soc'],
            ],

            [
                'title' => 'Solar Panel',
                'icon' => '☀️',
                'border' => 'border-orange-200',
                'value' => $this->energyData['pv_power'] . ' W',
                'subtitle' => sprintf(
                    '%s V • %s A',
                    $this->energyData['pv_voltage'],
                    $this->energyData['pv_current']
                ),
                'valueClass' => 'text-gray-900',
                'progress' => null,
            ],

            [
                'title' => 'Load',
                'icon' => '💡',
                'border' => 'border-green-200',
                'value' => $this->energyData['load_power'] . ' W',
                'subtitle' => $this->energyData['load_current'] . ' A',
                'valueClass' => 'text-gray-900',
                'progress' => null,
            ],
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.energy-cards');
    }
}
