<?php
namespace ActivityLog\Providers;

use Illuminate\Support\ServiceProvider;
use ActivityLog\Services\ActivityLogManager;

class ActivityLogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('activitylog', function ($app) {
            return new ActivityLogManager();
        });
    }

    public function boot()
    {
        // بارگذاری migration ها
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
