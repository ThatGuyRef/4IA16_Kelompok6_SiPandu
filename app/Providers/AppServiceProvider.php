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
        // Ensure the 'role' middleware alias is available on the router at runtime.
        // This prevents the container from attempting to resolve 'role' as a class
        // when the alias wasn't registered early enough in some environments.
        if ($this->app->bound('router')) {
            $this->app['router']->aliasMiddleware('role', \App\Http\Middleware\EnsureRole::class);
        }
    }
}
