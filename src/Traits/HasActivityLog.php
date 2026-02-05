<?php
namespace ActivityLog\Traits;

use ActivityLog\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait HasActivityLog
{
    public static function bootHasActivityLog()
    {
        static::created(function ($model) {
            self::logActivity($model, 'create');
        });

        static::updated(function ($model) {
            self::logActivity($model, 'update');
        });

        static::deleted(function ($model) {
            self::logActivity($model, 'delete');
        });
    }

    protected static function logActivity($model, $action)
    {
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'model'      => get_class($model),
            'action'     => $action,
            'model_id'   => $model->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'changes'    => $action === 'update' ? [
                'before' => $model->getOriginal(),
                'after'  => $model->getChanges(),
            ] : null,
            'meta'       => [
                'url'     => request()->fullUrl(),
                'method'  => request()->method(),
                'time'    => now()->toDateTimeString(),
            ],
        ]);
    }
}
