<?php

namespace App\Livewire\Components;

use Livewire\Component;

class BaseLineChart extends Component
{
    public string $field = '';
    public string $fieldName = '';
    public string $table = '';
    public string $groupby = '';
    public string $ylabel = '';
    public string $xlabel = '';

    public string $selectedPeriods = '6 hours';

    public array $periods = [
        '2 hours' => [
            'name' => 'Last 2 Hours',
        ],
        '6 hours' => [
            'name' => 'Last 6 Hours',
            'interval' => '15 minutes'
        ],
        '1 days' => [
            'name' => 'Last Day',
            'interval' => '1 hours'
        ],
        '1 weeks' => [
            'name' => 'Last Week',
            'interval' => '6 hours'
        ],
        '1 months' => [
            'name' => 'Last Month',
            'interval' => '1 days'
        ],
    ];

    public function mount(string $field, string $fieldName, string $table, string $groupby = '', string $ylabel = '', string | null $xlabel = null)
    {
        $this->fieldName = $fieldName ?? $xlabel;
        $this->xlabel = $xlabel ?? $fieldName;
        $this->field = $field;
        $this->table = $table;
        $this->groupby = $groupby;
        $this->ylabel = $ylabel;
    }

    public function placeholder()
    {
        return view('components.placeholder.line-chart-placeholder');
    }
}
