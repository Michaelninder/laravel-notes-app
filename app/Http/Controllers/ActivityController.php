<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::where('causer_id', Auth::id())
            ->with('subject')
            ->latest()
            ->paginate(20);

        return view('activity.index', compact('activities'));
    }
}