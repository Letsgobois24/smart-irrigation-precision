<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GlobalCards extends Component
{
    public float $ph;
    public float $water_flow;
    public bool $valve;
    public \Carbon\Carbon $time;
    public array $ph_config = [];
    public array $flow_config = [];
    public array $valve_config = [];

    public function __construct(
        array $globalData
    ) {
        $this->ph = $globalData['ph'];
        $this->water_flow = $globalData['water_flow'];
        $this->valve = false ?? $globalData['main_valve'];
        $this->time = $globalData['time'];

        $ph_status = $this->getStatusPH($this->ph);
        $this->ph_config = $this->getPHConfig($ph_status);

        $is_flow = $this->water_flow > 0;
        $this->flow_config = $this->getFlowConfig($is_flow);

        $this->valve_config = $this->getValveConfig($this->valve);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card.global-cards');
    }

    private function getStatusPH(float $ph): string
    {
        return match (true) {
            $ph < 5.5 => 'acid',
            $ph <= 7.5 => 'optimal',
            default => 'base',
        };
    }

    private function getPHConfig(string $status): array
    {
        return match ($status) {
            'acid' => [
                'label' => 'acid',
                'color' => 'red',
                'bg' => 'bg-red-50',
                'border' => 'border-red-100',
                'text' => 'text-red-700',
                'description' => 'pH terlalu asam.',
            ],
            'optimal' => [
                'label' => 'optimal',
                'color' => 'emerald',
                'bg' => 'bg-emerald-50',
                'border' => 'border-emerald-100',
                'text' => 'text-emerald-700',
                'description' => 'Kondisi pH optimal untuk irigasi.',
            ],
            default => [
                'label' => 'base',
                'color' => 'purple',
                'bg' => 'bg-purple-50',
                'border' => 'border-purple-100',
                'text' => 'text-purple-700',
                'description' => 'pH terlalu basa.',
            ],
        };
    }

    private function getFlowConfig(bool $is_flow): array
    {
        return match ($is_flow) {
            true => [
                'label' => 'flow',
                'color' => 'blue',
                'bg' => 'bg-sky-50',
                'border' => 'border-sky-100',
                'text' => 'text-blue-700',
                'description' => 'Distribusi air berjalan normal.',
            ],

            default => [
                'label' => 'idle',
                'color' => 'yellow',
                'bg' => 'bg-yellow-50',
                'border' => 'border-yellow-100',
                'text' => 'text-yellow-700',
                'description' => 'Tidak ada aliran air terdeteksi.',
            ],
        };
    }

    private function getValveConfig(bool $isActive): array
    {
        return match ($isActive) {
            true => [
                'label' => 'ON',
                'status' => 'Active',
                'color' => 'emerald',
                'bg' => 'bg-emerald-50',
                'border' => 'border-emerald-100',
                'text' => 'text-emerald-700',
                'icon' => 'text-emerald-600',
                'description' => 'Katup utama sedang membuka aliran.',
            ],

            default => [
                'label' => 'OFF',
                'status' => 'Non Active',
                'color' => 'red',
                'bg' => 'bg-red-50',
                'border' => 'border-red-100',
                'text' => 'text-red-700',
                'icon' => 'text-red-600',
                'description' => 'Katup utama sedang tertutup.',
            ]
        };
    }
}
