<?php
namespace ActivityLog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ActivityLog\Facades\ActivityLog;
use ActivityLog\Http\Resources\ActivityLogResource;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['user_id', 'model', 'action', 'date_from', 'date_to']);
        $logs = ActivityLog::all($filters);

        return ActivityLogResource::collection($logs);
    }

    public function search(Request $request)
    {
        $keyword = $request->get('q', '');
        $filters = $request->only(['user_id', 'model', 'action']);
        $logs = ActivityLog::search($keyword, $filters);

        return ActivityLogResource::collection($logs);
    }

    public function stats()
    {
        return response()->json(ActivityLog::stats());
    }
}
