<?php

namespace Modules\Admin\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?int $navigationSort = -2;

    public function getTitle(): string
    {
        return __('admin.dashboard.title');
    }

    public function getHeading(): string
    {
        return __('admin.dashboard.welcome', ['name' => auth()->guard('admin')->user()->name]);
    }

    public function getSubheading(): ?string
    {
        return __('admin.dashboard.subtitle');
    }
}
