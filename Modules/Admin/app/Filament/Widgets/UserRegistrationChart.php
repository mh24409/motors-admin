<?php

namespace Modules\Admin\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Modules\Api\Models\User;

class UserRegistrationChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '300px';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'md' => 1,
    ];

    public ?string $filter = '6months';

    public function getHeading(): ?string
    {
        return __('admin.widgets.user_registrations');
    }

    public function getDescription(): ?string
    {
        return __('admin.widgets.user_registrations_desc');
    }

    protected function getFilters(): ?array
    {
        return [
            '7days' => __('admin.widgets.filter_7days'),
            '30days' => __('admin.widgets.filter_30days'),
            '6months' => __('admin.widgets.filter_6months'),
            '12months' => __('admin.widgets.filter_12months'),
        ];
    }

    protected function getData(): array
    {
        $filter = $this->filter;

        if ($filter === '7days') {
            $data = collect(range(6, 0))->map(function ($daysAgo) {
                $date = Carbon::today()->subDays($daysAgo);
                return [
                    'label' => $date->format('D'),
                    'count' => User::whereDate('created_at', $date)->count(),
                ];
            });
        } elseif ($filter === '30days') {
            $data = collect(range(29, 0))->map(function ($daysAgo) {
                $date = Carbon::today()->subDays($daysAgo);
                return [
                    'label' => $date->format('d M'),
                    'count' => User::whereDate('created_at', $date)->count(),
                ];
            });
        } elseif ($filter === '12months') {
            $data = collect(range(11, 0))->map(function ($monthsAgo) {
                $date = Carbon::now()->subMonths($monthsAgo);
                return [
                    'label' => $date->format('M Y'),
                    'count' => User::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count(),
                ];
            });
        } else {
            $data = collect(range(5, 0))->map(function ($monthsAgo) {
                $date = Carbon::now()->subMonths($monthsAgo);
                return [
                    'label' => $date->format('M Y'),
                    'count' => User::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->count(),
                ];
            });
        }

        return [
            'datasets' => [
                [
                    'label' => __('admin.widgets.registrations'),
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(99, 102, 241, 0.15)',
                    'borderColor' => 'rgb(99, 102, 241)',
                    'pointBackgroundColor' => 'rgb(99, 102, 241)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 6,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->pluck('label')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
