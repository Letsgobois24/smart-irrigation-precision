<?php

namespace App\View\Components\Card;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GlobalCards extends Component
{
    public array $ph_config = [];
    public array $flow_config = [];
    public array $valve_config = [];
    public array $light_config = [];

    public function __construct(
        public array $globalData
    ) {
        // Determine pH status and configuration
        $ph_status = $this->getStatusPH($globalData['ph']);
        $this->ph_config = $this->getPHConfig($ph_status);
        $this->ph_config['title'] = 'pH Tanah';

        // Determine water flow status and configuration
        $is_flow = $globalData['water_flow'] > 0;
        $this->flow_config = $this->getFlowConfig($is_flow);
        $this->flow_config['title'] = 'Water Flow';

        // Determine light status and configuration
        $this->light_config = $this->getLightConfig($globalData['light']);
        $this->light_config['title'] = 'Light Intensity';

        // Determine valve status and configuration
        $this->valve_config = $this->getValveConfig($globalData['main_valve']);
        $this->valve_config['title'] = 'Main Valve';
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
                'border' => 'border-red-200',
                'accent' => 'border-l-red-500',
                'text' => 'text-red-700',
                'bg-icon' => 'bg-red-700/10',
                'description' => 'pH terlalu asam.',
            ],
            'optimal' => [
                'label' => 'optimal',
                'color' => 'emerald',
                'border' => 'border-emerald-200',
                'accent' => 'border-l-emerald-500',
                'text' => 'text-emerald-700',
                'bg-icon' => 'bg-emerald-700/10',
                'description' => 'pH optimal untuk irigasi.',
            ],
            default => [
                'label' => 'base',
                'color' => 'purple',
                'border' => 'border-purple-200',
                'accent' => 'border-l-purple-500',
                'text' => 'text-purple-700',
                'bg-icon' => 'bg-purple-700/10',
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
                'border' => 'border-sky-200',
                'accent' => 'border-l-sky-500',
                'bg-icon' => 'bg-sky-700/10',
                'text' => 'text-sky-700',
                'description' => 'Distribusi air berjalan normal.',
            ],

            default => [
                'label' => 'idle',
                'color' => 'yellow',
                'border' => 'border-yellow-200',
                'accent' => 'border-l-yellow-500',
                'bg-icon' => 'bg-yellow-700/10',
                'text' => 'text-yellow-700',
                'description' => 'Tidak ada aliran air terdeteksi.',
            ],
        };
    }

    private function getLightConfig(int $light): array
    {
        return match (true) {
            $light <= 20 => [
                'label' => 'dark',
                'color' => 'slate',
                'bg-icon' => 'bg-slate-700/10',
                'border' => 'border-slate-200',
                'accent' => 'border-l-slate-500',
                'text' => 'text-slate-700',
                'description' => 'Intensitas cahaya sangat rendah.',
            ],

            $light <= 50 => [
                'label' => 'low',
                'color' => 'yellow',
                'bg-icon' => 'bg-yellow-700/10',
                'border' => 'border-yellow-200',
                'accent' => 'border-l-yellow-500',
                'text' => 'text-yellow-700',
                'description' => 'Cahaya masih relatif rendah.',
            ],

            $light <= 80 => [
                'label' => 'moderate',
                'color' => 'amber',
                'bg-icon' => 'bg-amber-700/10',
                'border' => 'border-amber-200',
                'accent' => 'border-l-amber-500',
                'text' => 'text-amber-700',
                'description' => 'Intensitas cahaya berada pada level sedang.',
            ],

            default => [
                'label' => 'bright',
                'color' => 'orange',
                'bg-icon' => 'bg-orange-700/10',
                'border' => 'border-orange-200',
                'accent' => 'border-l-orange-500',
                'text' => 'text-orange-700',
                'description' => 'Intensitas cahaya tinggi.',
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
                'border' => 'border-emerald-200',
                'accent' => 'border-l-emerald-500',
                'text' => 'text-emerald-700',
                'icon' => 'text-emerald-600',
                'bg-icon' => 'bg-emerald-700/10',
                'description' => 'Katup utama sedang membuka aliran.',
            ],

            default => [
                'label' => 'OFF',
                'status' => 'Non Active',
                'color' => 'red',
                'border' => 'border-red-200',
                'accent' => 'border-l-red-500',
                'text' => 'text-red-700',
                'icon' => 'text-red-600',
                'bg-icon' => 'bg-red-700/10',
                'description' => 'Katup utama sedang tertutup.',
            ],
        };
    }
}
