<?php

namespace Modules\Admin\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;
use Modules\Api\Models\User;

class UserRegistrationChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected static ?string $maxHeight = '300px';

    public function getHeading(): ?string
    {
        return __('admin.widgets.user_registrations');
    }

    public function getDescription(): ?string
    {
        return __('admin.widgets.user_registrations_desc');
    }

    protected function getData(): array
    {
        $months = collect(range(5, 0))->map(function ($monthsAgo) {
            $date = Carbon::now()->subMonths($monthsAgo);
            return [
                'month' => $date->format('M Y'),
                'count' => User::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->count(),
            ];
        });

        return [
            'datasets' => [
                [
                    'label' => __('admin.widgets.registrations'),
                    'data' => $months->pluck('count')->toArray(),
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)',
                    'borderColor' => 'rgb(99, 102, 241)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $months->pluck('month')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
