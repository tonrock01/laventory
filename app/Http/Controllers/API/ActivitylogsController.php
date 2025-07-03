<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockLog;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivitylogsController extends Controller
{
    protected $activityLogService;

    public function __construct(ActivityService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }
    
    /**
     * Display a listing of the Activities.
     */
    public function index(Request $request)
    {
        $activities = $this->activityLogService->index($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'data' => $activities
        ], 200);
    }
}
