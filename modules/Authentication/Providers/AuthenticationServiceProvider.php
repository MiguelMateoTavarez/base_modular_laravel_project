<?php

namespace Modules\Authentication\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Authentication\Eloquents\Contracts\AuthServiceInterface;
use Modules\Authentication\Eloquents\Services\AuthSanctumService;

class AuthenticationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations/*');
        $this->loadTranslationsFrom(__DIR__.'/../Lang/es.json', 'Authentication');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(
            AuthServiceInterface::class,
            AuthSanctumService::class
        );
    }
}
