<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TrashController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $notebooks = Auth::user()->noteBooks()
            ->onlyTrashed()
            ->latest('deleted_at')
            ->get();

        $notes = Note::where(function ($query) {
            $query->where('notable_type', \App\Models\User::class)
                ->where('notable_id', Auth::id());
        })->orWhereHasMorph('notable', [NoteBook::class], function ($query) {
            $query->where('user_id', Auth::id());
        })->onlyTrashed()
          ->latest('deleted_at')
          ->get();

        return view('trash.index', compact('notebooks', 'notes'));
    }

    public function restore(Request $request, string $type, string $id)
    {
        $model = $type === 'notebook' ? NoteBook::class : Note::class;
        
        $item = $model::onlyTrashed()->findOrFail($id);
        
        if ($type === 'notebook') {
            $this->authorize('restore', $item);
        } else {
            $this->authorize('restore', $item);
        }

        $item->restore();

        return redirect()
            ->route('trash.index')
            ->with('success', ucfirst($type) . ' restored successfully.');
    }

    public function forceDelete(Request $request, string $type, string $id)
    {
        $model = $type === 'notebook' ? NoteBook::class : Note::class;
        
        $item = $model::onlyTrashed()->findOrFail($id);
        
        if ($type === 'notebook') {
            $this->authorize('forceDelete', $item);
        } else {
            $this->authorize('forceDelete', $item);
        }

        $item->forceDelete();

        return redirect()
            ->route('trash.index')
            ->with('success', ucfirst($type) . ' permanently deleted.');
    }
}