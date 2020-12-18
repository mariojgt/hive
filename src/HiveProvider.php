<?php
namespace Mariojgt\Hive;

use Illuminate\Support\ServiceProvider;

class HiveProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load hive views
        $this->loadViewsFrom(__DIR__.'/views', 'hive');

        // Load hive routes
        $this->loadRoutesFrom(__DIR__.'/Routes/web.php');

        // Load migration
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publish();
    }

    public function publish()
    {
        //publish the npm case we need to do soem developent
        // $this->publishes([
        //     __DIR__.'/../Publish/Npm/' => base_path()
        // ]);

        // publish the resource in case we need to compile
        // $this->publishes([
        //     __DIR__.'/../Publish/Resource/' => resource_path('vendor/Peach/')
        // ]);

        // publish the public folder
        // $this->publishes([
        //     __DIR__.'/../Publish/' => public_path('vendor/Peach/')
        // ]);
    }
}
