<?php
namespace ActivityLog\Providers;

use ActivityLog\Observers\GlobalActivityObserver;
use Illuminate\Database\Eloquent\Model;
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
        Model::observe(GlobalActivityObserver::class);
        // بارگذاری migration ها
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
