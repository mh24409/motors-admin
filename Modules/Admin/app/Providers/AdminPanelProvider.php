<?php

namespace Modules\Admin\Providers;

use App\Http\Middleware\SetLocale;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Modules\Admin\Filament\Pages\Dashboard;
use Modules\Admin\Filament\Widgets\LatestUsersWidget;
use Modules\Admin\Filament\Widgets\StatsOverviewWidget;
use Modules\Admin\Filament\Widgets\UserRegistrationChart;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->default()
            ->path('admin')
            ->login()
            ->profile(\Modules\Admin\Filament\Pages\EditProfile::class)
            ->authGuard('admin')
            ->colors([
                'primary' => Color::Indigo,
                'danger' => Color::Rose,
                'gray' => Color::Zinc,
                'info' => Color::Sky,
                'success' => Color::Emerald,
                'warning' => Color::Amber,
            ])
            ->font('Inter')
            ->brandName('Motors Admin')
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                NavigationGroup::make()
                    ->label(fn () => __('admin.nav.user_management')),
                NavigationGroup::make()
                    ->label(fn () => __('admin.nav.admin_management')),
                NavigationGroup::make()
                    ->label(fn () => __('admin.nav.access_control')),
                NavigationGroup::make()
                    ->label(fn () => __('admin.nav.settings')),
            ])
            ->discoverResources(
                in: base_path('Modules/Admin/app/Filament/Resources'),
                for: 'Modules\\Admin\\Filament\\Resources'
            )
            ->discoverPages(
                in: base_path('Modules/Admin/app/Filament/Pages'),
                for: 'Modules\\Admin\\Filament\\Pages'
            )
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(
                in: base_path('Modules/Admin/app/Filament/Widgets'),
                for: 'Modules\\Admin\\Filament\\Widgets'
            )
            ->widgets([
                StatsOverviewWidget::class,
                UserRegistrationChart::class,
                LatestUsersWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make(),
            ])
            ->databaseNotifications()
            ->globalSearchKeyBindings(['command+k', 'ctrl+k'])
            ->renderHook(
                PanelsRenderHook::USER_MENU_BEFORE,
                fn (): string => Blade::render('@livewire(\'admin::language-switcher\')')
            );
    }
}
