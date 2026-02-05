<?php

namespace ActivityLog\Observers;

use ActivityLog\Facades\ActivityLog;
use Illuminate\Database\Eloquent\Model;

class GlobalActivityObserver
{
    private $exceptModels=['ActivityLog\Models\ActivityLog'];

    public function __construct(){
        $this->exceptModels =array_merge($this->exceptModels,config('activity-log.except-models'));
    }
    private function isNotExcepted(Model $model)
    {
        return !in_array(get_class($model),$this->exceptModels);
    }
    public function created(Model $model)
    {
        if ($this->isNotExcepted($model)) {
            $this->log($model, 'create');
        }
    }

    public function updated(Model $model)
    {
        if ($this->isNotExcepted($model)) {
            $this->log($model, 'update');
        }
    }

    public function deleted(Model $model)
    {
        if ($this->isNotExcepted($model)) {
            $this->log($model, 'delete');
        }
    }

    protected function log(Model $model, $action)
    {
        ActivityLog::log([
            'user_id' => auth()->id(),
            'model' => get_class($model),
            'action' => $action,
            'model_id' => $model->getKey(),
            'changes' => $action === 'update' ? [
                'before' => $model->getOriginal(),
                'after' => $model->getChanges(),
            ] : null,
        ]);
    }
}
