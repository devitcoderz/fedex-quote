<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;

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
        $router = $this->app['router'];

        // Register middleware globally
        $router->aliasMiddleware('auth.admin', AdminMiddleware::class);
        $router->aliasMiddleware('auth.user', UserMiddleware::class);

    }
}
