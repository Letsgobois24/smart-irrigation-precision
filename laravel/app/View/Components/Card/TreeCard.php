<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TreeCard extends Component
{
    public array $statusConfig = [];

    public function __construct(
        public array $tree,
    ) {
        $status = $this->getMoistureStatus(
            $tree['soil_moisture']
        );

        $this->statusConfig = $this->getStatusConfig($status);
    }

    public function render(): View|Closure|string
    {
        return view('components.card.tree-card');
    }

    private function getMoistureStatus(float $moisture): string
    {
        return match (true) {
            $moisture < 30 => 'dry',
            $moisture > 70 => 'wet',
            default => 'optimal',
        };
    }

    private function getStatusConfig(string $status): array
    {
        return match ($status) {

            'dry' => [
                'badge' => 'Soil Dry',
                'badge_color' => 'red',
                'card' => 'bg-red-50 border border-red-200',
                'icon' => 'text-red-500',
                'description' => 'Irrigation recommended',
                'description_color' => 'text-red-600',
            ],

            'wet' => [
                'badge' => 'Too Wet',
                'badge_color' => 'yellow',
                'card' => 'bg-yellow-50 border border-yellow-200',
                'icon' => 'text-yellow-500',
                'description' => 'Soil moisture too high',
                'description_color' => 'text-yellow-700',
            ],

            default => [
                'badge' => 'Optimal',
                'badge_color' => 'green',
                'card' => 'bg-green-50 border border-green-200',
                'icon' => 'text-blue-500',
                'description' => 'Soil condition stable',
                'description_color' => 'text-green-600',
            ],
        };
    }
}
