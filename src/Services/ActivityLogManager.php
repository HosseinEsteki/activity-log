<?php

namespace ActivityLog\Services;

use ActivityLog\Models\ActivityLog as ActivityLogModel;

class ActivityLogManager
{
    public function log($data)
    {
        return ActivityLogModel::create($data);
    }

    public function all($filters = [])
    {
        return ActivityLogModel::query()
            ->when(isset($filters['user_id']), fn ($q) => $q->where('user_id', $filters['user_id']))
            ->when(isset($filters['model']), fn ($q) => $q->where('model', $filters['model']))
            ->when(isset($filters['action']), fn ($q) => $q->where('action', $filters['action']))
            ->when(isset($filters['date_from']), fn ($q) => $q->whereDate('created_at', '>=', $filters['date_from']))
            ->when(isset($filters['date_to']), fn ($q) => $q->whereDate('created_at', '<=', $filters['date_to']))
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function search(string $keyword, $filters = [])
    {
        return ActivityLogModel::query()
            ->where(function ($q) use ($keyword) {
                $q->where('model', 'like', "%{$keyword}%")
                    ->orWhere('action', 'like', "%{$keyword}%")
                    ->orWhere('user_agent', 'like', "%{$keyword}%")
                    ->orWhereJsonContains('changes->after', $keyword);
            })
            ->when(isset($filters['user_id']), fn ($q) => $q->where('user_id', $filters['user_id']))
            ->when(isset($filters['model']), fn ($q) => $q->where('model', $filters['model']))
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
