<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TreeCard extends Component
{
    public array $statusConfig = [];
    public array $faultConfig = [];

    public function __construct(
        public array $tree,
    ) {
        $status = $this->getMoistureStatus(
            $tree['soil_moisture']
        );

        $this->faultConfig = $this->getFaultStatus(
            $tree['total_anomaly']
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
                'badge' => 'Dry',
                'badge_color' => 'red',
                'card' => 'border-red-500 border-red-100',
                'icon' => 'text-red-500',
                'description' => 'Penyiraman diperlukan',
                'description_color' => 'text-red-600',
            ],

            'wet' => [
                'badge' => 'Wet',
                'badge_color' => 'yellow',
                'card' => 'border-yellow-500 border-yellow-100',
                'icon' => 'text-yellow-500',
                'description' => 'Kelembapan tanah terlalu tinggi',
                'description_color' => 'text-yellow-700',
            ],

            default => [
                'badge' => 'Optimal',
                'badge_color' => 'green',
                'card' => 'border-green-500 border-green-100',
                'icon' => 'text-blue-500',
                'description' => 'Kondisi tanah stabil',
                'description_color' => 'text-green-600',
            ],
        };
    }

    private function getFaultStatus(int $totalFaults): array
    {
        return match (true) {
            $totalFaults >= 5 => [
                'icon' => 'warning',
                'text_color' => 'text-red-600',
            ],

            $totalFaults > 0 => [
                'icon' => 'warning',
                'text_color' => 'text-yellow-700',
            ],

            default => [
                'icon' => 'check',
                'text_color' => 'text-green-600',
            ],
        };
    }
}
