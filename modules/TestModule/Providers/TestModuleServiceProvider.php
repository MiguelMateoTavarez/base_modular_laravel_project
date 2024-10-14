<?php

namespace Modules\TestModule\Providers;

use Illuminate\Support\ServiceProvider;

class TestModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/api.php');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../Lang/es.json', 'TestModule');
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        //
    }
}
