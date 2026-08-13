<?php

namespace Modules\Admin\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Modules\Api\Models\User;

class UserStatusChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected static ?string $maxHeight = '300px';

    protected int|string|array $columnSpan = [
        'default' => 'full',
        'md' => 1,
    ];

    public function getHeading(): ?string
    {
        return __('admin.widgets.user_status_breakdown');
    }

    public function getDescription(): ?string
    {
        return __('admin.widgets.user_status_desc');
    }

    protected function getData(): array
    {
        $active = User::where('is_active', true)->count();
        $inactive = User::where('is_active', false)->count();
        $verified = User::whereNotNull('email_verified_at')->count();
        $unverified = User::whereNull('email_verified_at')->count();

        return [
            'datasets' => [
                [
                    'data' => [$active, $inactive, $verified, $unverified],
                    'backgroundColor' => [
                        'rgb(16, 185, 129)',   // emerald — active
                        'rgb(239, 68, 68)',    // red — inactive
                        'rgb(59, 130, 246)',   // blue — verified
                        'rgb(245, 158, 11)',   // amber — unverified
                    ],
                    'borderColor' => 'transparent',
                    'hoverOffset' => 8,
                ],
            ],
            'labels' => [
                __('admin.widgets.active_users'),
                __('admin.widgets.inactive_users'),
                __('admin.widgets.verified_users'),
                __('admin.widgets.unverified_users'),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'padding' => 16,
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                    ],
                ],
            ],
            'cutout' => '65%',
        ];
    }
}
