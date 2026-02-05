<?php
namespace ActivityLog\Observers;

use Illuminate\Database\Eloquent\Model;
use ActivityLog\Facades\ActivityLog;

class GlobalActivityObserver
{
    public function created(Model $model)
    {
        $this->log($model, 'create');
    }

    public function updated(Model $model)
    {
        $this->log($model, 'update');
    }

    public function deleted(Model $model)
    {
        $this->log($model, 'delete');
    }

    protected function log(Model $model, $action)
    {
        ActivityLog::log([
            'user_id'  => auth()->id(),
            'model'    => get_class($model),
            'action'   => $action,
            'model_id' => $model->getKey(),
            'changes'  => $action === 'update' ? [
                'before' => $model->getOriginal(),
                'after'  => $model->getChanges(),
            ] : null,
        ]);
    }
}
