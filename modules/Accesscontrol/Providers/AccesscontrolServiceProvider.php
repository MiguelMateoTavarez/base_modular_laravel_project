<?php

namespace Modules\Accesscontrol\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Accesscontrol\Eloquents\Contracts\RoleInterface;
use Modules\Accesscontrol\Eloquents\Services\RoleService;

class AccesscontrolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__.'/../Lang/es.json', 'Accesscontrol');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind(
            RoleInterface::class,
            RoleService::class
        );
    }
}
