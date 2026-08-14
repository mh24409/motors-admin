<?php

namespace Modules\Admin\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Admin\Http\Livewire\LanguageSwitcher;
use Modules\Admin\Models\Admin;
use Modules\Admin\Policies\UserPolicy;
use Modules\Api\Models\User;
use App\Models\Language;
use Spatie\Permission\Models\Role;

class AdminServiceProvider extends ServiceProvider
{
    protected string $moduleName = 'Admin';

    protected string $moduleNameLower = 'admin';

    /**
     * Boot the application events.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'database/migrations'));
        $this->loadViewsFrom(module_path($this->moduleName, 'resources/views'), $this->moduleNameLower);

        // Define the super_admin gate for Filament Shield
        Gate::before(function (Admin $user, $ability) {
            return $user->hasRole('super_admin') ? true : null;
        });

        // Register Livewire components
        Livewire::component('admin::language-switcher', LanguageSwitcher::class);
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AdminPanelProvider::class);
    }

    /**
     * Register policies.
     */
    protected function registerPolicies(): void
    {
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Admin::class, \Modules\Admin\Policies\AdminPolicy::class);
        Gate::policy(Language::class, \App\Policies\LanguagePolicy::class);
        Gate::policy(Role::class, \App\Policies\RolePolicy::class);
    }

    /**
     * Register config.
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');

        $this->mergeConfigFrom(
            module_path($this->moduleName, 'config/config.php'),
            $this->moduleNameLower
        );
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
