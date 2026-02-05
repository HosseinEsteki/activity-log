<?php

namespace ActivityLog\Providers;

use ActivityLog\Observers\GlobalActivityObserver;
use ActivityLog\Services\ActivityLogManager;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class ActivityLogServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('activitylog', function ($app) {
            return new ActivityLogManager;
        });
    }

    public function boot()
    {
        //ذخیره ی اتوماتیک لاگ ها در جدول
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

        // بارگذاری کانفیگ ها
        $this->mergeConfigFrom(__DIR__.'/../config/activity-log.php', 'activity-log');
    }
}
