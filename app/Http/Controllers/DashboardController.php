<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteBook;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $recentNotebooks = $user->noteBooks()
            ->withCount('notes')
            ->latest()
            ->take(5)
            ->get();

        $totalNotes = Note::where(function ($query) use ($user) {
            $query->where('notable_type', User::class)
                ->where('notable_id', $user->id);
        })->orWhereHasMorph('notable', [NoteBook::class], function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $recentNotes = Note::where(function ($query) use ($user) {
            $query->where('notable_type', User::class)
                ->where('notable_id', $user->id);
        })->orWhereHasMorph('notable', [NoteBook::class], function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->latest()->take(5)->get();

        $recentActivities = Activity::where('causer_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'recentNotebooks',
            'recentNotes',
            'totalNotes',
            'recentActivities'
        ));
    }
}