<?php

namespace ActivityLog\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id', 'model', 'action', 'model_id',
        'ip_address', 'user_agent', 'changes', 'meta'
    ];

    protected $casts = [
        'changes' => 'array',
        'meta'    => 'array',
    ];
}
