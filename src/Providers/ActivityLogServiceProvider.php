<?php
namespace ActivityLog\Providers;

use ActivityLog\Observers\GlobalActivityObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use ActivityLog\Services\ActivityLogManager;

class ActivityLogServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->app->singleton('activitylog', function ($app) {
//            return new ActivityLogManager();
//        });
    }

    public function boot()
    {
        Event::listen('eloquent.created:*', function ($event, $models) {
            foreach ($models as $model) {
                (new GlobalActivityObserver)->created($model);
            }
        });

        Event::listen('eloquent.updated:*', function ($event, $models) {
            foreach ($models as $model) {
                (new GlobalActivityObserver)->updated($model);
            }
        });

        Event::listen('eloquent.deleted:*', function ($event, $models) {
            foreach ($models as $model) {
                (new GlobalActivityObserver)->deleted($model);
            }
        });

        // بارگذاری migration ها
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
