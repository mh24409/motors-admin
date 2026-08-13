<?php

namespace Modules\Admin\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Admin\Models\Admin;
use Modules\Api\Models\User;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalAdmins = Admin::count();
        $totalUsers = User::count();
        $activeUsers = User::where('is_active', true)->count();
        $inactiveUsers = User::where('is_active', false)->count();

        return [
            Stat::make(__('admin.widgets.total_admins'), $totalAdmins)
                ->description(__('admin.widgets.system_administrators'))
                ->descriptionIcon('heroicon-m-shield-check')
                ->chart([2, 3, 3, 4, 4, $totalAdmins])
                ->color('primary'),

            Stat::make(__('admin.widgets.total_users'), $totalUsers)
                ->description(__('admin.widgets.registered_users'))
                ->descriptionIcon('heroicon-m-users')
                ->chart([10, 15, 20, 25, 30, $totalUsers])
                ->color('info'),

            Stat::make(__('admin.widgets.active_users'), $activeUsers)
                ->description(__('admin.widgets.currently_active'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->chart([5, 8, 12, 18, 22, $activeUsers])
                ->color('success'),

            Stat::make(__('admin.widgets.inactive_users'), $inactiveUsers)
                ->description(__('admin.widgets.deactivated_accounts'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->chart([1, 2, 2, 3, 3, $inactiveUsers])
                ->color('danger'),
        ];
    }
}
