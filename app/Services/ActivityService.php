<?php

namespace App\Services;

use App\Models\Product;
use Spatie\Activitylog\Models\Activity;

class ActivityService
{
    public function index(array $filters = [])
    {
        return Activity::latest()->paginate(10);
    }
}
