<?php
use Illuminate\Support\Facades\Route;
use ActivityLog\Http\Controllers\ActivityLogController;

Route::prefix('api/activity-log')->group(function () {
    Route::get('/', [ActivityLogController::class, 'index']);
    Route::get('/search', [ActivityLogController::class, 'search']);
    Route::get('/stats', [ActivityLogController::class, 'stats']);
});
