<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteBook;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteController extends Controller
{
    use AuthorizesRequests;
    
    public function index()
    {
        $notes = Note::where(function ($query) {
            $query->where('notable_type', User::class)
                ->where('notable_id', Auth::id());
        })->orWhereHasMorph('notable', [NoteBook::class], function ($query) {
            $query->where('user_id', Auth::id());
        })->latest()->get();

        return view('notes.index', compact('notes'));
    }

    public function create(Request $request)
    {
        $notableType = $request->query('notable_type');
        $notableId = $request->query('notable_id');

        $notebooks = Auth::user()->noteBooks;

        return view('notes.create', compact(
            'notableType',
            'notableId',
            'notebooks'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'notable_type' => 'required|string|in:' . User::class . ',' 
                . NoteBook::class,
            'notable_id' => 'required|uuid',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        if ($validated['notable_type'] === NoteBook::class) {
            $notebook = NoteBook::findOrFail($validated['notable_id']);
            $this->authorize('view', $notebook);
        } elseif ($validated['notable_id'] !== Auth::id()) {
            abort(403);
        }

        $note = Note::create($validated);

        return redirect()
            ->route('notes.show', $note)
            ->with('success', 'Note created successfully.');
    }

    public function show(Note $note)
    {
        $this->authorize('view', $note);

        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        $this->authorize('update', $note);

        $notebooks = Auth::user()->noteBooks;

        return view('notes.edit', compact('note', 'notebooks'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $validated = $request->validate([
            'notable_type' => 'required|string|in:' . User::class . ',' 
                . NoteBook::class,
            'notable_id' => 'required|uuid',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
        ]);

        if ($validated['notable_type'] === NoteBook::class) {
            $notebook = NoteBook::findOrFail($validated['notable_id']);
            $this->authorize('view', $notebook);
        } elseif ($validated['notable_id'] !== Auth::id()) {
            abort(403);
        }

        $note->update($validated);

        return redirect()
            ->route('notes.show', $note)
            ->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);

        $note->delete();

        return redirect()
            ->route('notes.index')
            ->with('success', 'Note moved to trash.');
    }
}