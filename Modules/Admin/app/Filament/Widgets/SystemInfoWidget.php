<?php

namespace Modules\Admin\Filament\Widgets;

use App\Models\Language;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Modules\Admin\Models\Admin;
use Modules\Api\Models\User;
use Spatie\Permission\Models\Role;

class SystemInfoWidget extends Widget
{
    protected static ?int $sort = 5;

    protected static string $view = 'admin::widgets.system-info';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'items' => [
                [
                    'label' => __('admin.widgets.total_roles'),
                    'value' => Role::count(),
                    'icon' => 'heroicon-o-shield-check',
                    'color' => 'text-indigo-500 dark:text-indigo-400',
                    'bg' => 'bg-indigo-50 dark:bg-indigo-500/10',
                ],
                [
                    'label' => __('admin.widgets.active_languages'),
                    'value' => Language::where('is_active', true)->count(),
                    'icon' => 'heroicon-o-language',
                    'color' => 'text-emerald-500 dark:text-emerald-400',
                    'bg' => 'bg-emerald-50 dark:bg-emerald-500/10',
                ],
                [
                    'label' => __('admin.widgets.total_admins'),
                    'value' => Admin::count(),
                    'icon' => 'heroicon-o-user-group',
                    'color' => 'text-amber-500 dark:text-amber-400',
                    'bg' => 'bg-amber-50 dark:bg-amber-500/10',
                ],
                [
                    'label' => __('admin.widgets.active_sessions'),
                    'value' => DB::table('sessions')->count(),
                    'icon' => 'heroicon-o-signal',
                    'color' => 'text-sky-500 dark:text-sky-400',
                    'bg' => 'bg-sky-50 dark:bg-sky-500/10',
                ],
            ],
        ];
    }
}
