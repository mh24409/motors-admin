<?php

namespace Modules\Api\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Modules\Api\Http\Middleware\SetLanguage;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'Api';

    /**
     * Called before routes are registered.
     */
    public function boot(): void
    {
        parent::boot();

        Route::aliasMiddleware('setLanguage', SetLanguage::class);

    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are stateless and use Sanctum for authentication.
     */
    protected function mapApiRoutes(): void
    {
        Route::middleware(['api', 'setLanguage'])
            ->prefix('api')
            ->group(module_path($this->name, '/routes/api.php'));
    }
}
