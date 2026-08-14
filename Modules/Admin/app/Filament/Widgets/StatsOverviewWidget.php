<?php

namespace Modules\Admin\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Modules\Admin\Models\Admin;
use Modules\Api\Models\User;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class StatsOverviewWidget extends BaseWidget
{
    use HasWidgetShield;
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalAdmins = Admin::count();
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $newUsersToday = User::whereDate('created_at', Carbon::today())->count();
        $newUsersThisWeek = User::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        $newUsersLastWeek = User::whereBetween('created_at', [
            Carbon::now()->subWeek()->startOfWeek(),
            Carbon::now()->subWeek()->endOfWeek(),
        ])->count();

        // Calculate growth percentage
        $growthPercent = $newUsersLastWeek > 0
            ? round((($newUsersThisWeek - $newUsersLastWeek) / $newUsersLastWeek) * 100, 1)
            : ($newUsersThisWeek > 0 ? 100 : 0);

        $growthDesc = $growthPercent >= 0
            ? __('admin.widgets.growth_up', ['percent' => abs($growthPercent)])
            : __('admin.widgets.growth_down', ['percent' => abs($growthPercent)]);

        // Generate sparkline data (last 7 days)
        $sparkline = collect(range(6, 0))->map(fn ($daysAgo) =>
            User::whereDate('created_at', Carbon::today()->subDays($daysAgo))->count()
        )->toArray();

        $activePercent = $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100) : 0;

        return [
            Stat::make(__('admin.widgets.total_users'), number_format($totalUsers))
                ->description($growthDesc)
                ->descriptionIcon($growthPercent >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->chart($sparkline)
                ->color($growthPercent >= 0 ? 'success' : 'danger'),

            Stat::make(__('admin.widgets.active_users'), number_format($activeUsers))
                ->description("{$activePercent}% " . __('admin.widgets.of_total'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart([max(1, $activePercent)])
                ->color('success'),

            Stat::make(__('admin.widgets.new_today'), number_format($newUsersToday))
                ->description(__('admin.widgets.registered_today'))
                ->descriptionIcon('heroicon-m-user-plus')
                ->chart($sparkline)
                ->color('info'),

            Stat::make(__('admin.widgets.total_admins'), number_format($totalAdmins))
                ->description(__('admin.widgets.system_administrators'))
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),
        ];
    }
}
