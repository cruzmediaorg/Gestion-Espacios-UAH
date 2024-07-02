<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityLogResource;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('Control/Logs/Index',
            [
                'logs' => ActivityLogResource::collection(Activity::all()->sortByDesc('created_at')),
            ]);
    }
}
