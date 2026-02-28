<?php

namespace App\Http\Controllers;

use App\Models\NoteBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class NoteBookController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $notebooks = Auth::user()->noteBooks()
            ->withCount('notes')
            ->latest()
            ->get();

        return view('notebooks.index', compact('notebooks'));
    }

    public function create()
    {
        return view('notebooks.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $notebook = Auth::user()->noteBooks()->create($validated);

        return redirect()
            ->route('notebooks.show', $notebook)
            ->with('success', 'Notebook created successfully.');
    }

    public function show(NoteBook $notebook)
    {
        $this->authorize('view', $notebook);

        $notebook->load(['notes' => function ($query) {
            $query->latest();
        }]);

        return view('notebooks.show', compact('notebook'));
    }

    public function edit(NoteBook $notebook)
    {
        $this->authorize('update', $notebook);

        return view('notebooks.edit', compact('notebook'));
    }

    public function update(Request $request, NoteBook $notebook)
    {
        $this->authorize('update', $notebook);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:50',
        ]);

        $notebook->update($validated);

        return redirect()
            ->route('notebooks.show', $notebook)
            ->with('success', 'Notebook updated successfully.');
    }

    public function destroy(NoteBook $notebook)
    {
        $this->authorize('delete', $notebook);

        $notebook->delete();

        return redirect()
            ->route('notebooks.index')
            ->with('success', 'Notebook moved to trash.');
    }
}