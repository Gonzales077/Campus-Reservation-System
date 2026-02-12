<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register route middleware aliases that may be missing
        if ($this->app->bound('router')) {
            $this->app['router']->aliasMiddleware('is.admin', \App\Http\Middleware\IsAdmin::class);
        }
    }
}
