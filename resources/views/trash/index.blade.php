@extends('layouts.app')

@section('content')
<h1>Trash</h1>

<p>Deleted items are kept for 30 days before being permanently removed.</p>

<h2>Notebooks</h2>
@if ($notebooks->isEmpty())
    <p>No deleted notebooks.</p>
@else
    <ul>
        @foreach ($notebooks as $notebook)
            <li>
                {{ $notebook->name }}
                <small>Deleted {{ $notebook->deleted_at?->diffForHumans() ?? 'Unknown date' }}</small>
                
                <form method="POST" 
                      action="{{ route('trash.restore', ['type' => 'notebook', 'id' => $notebook->id]) }}" 
                      style="display: inline;">
                    @csrf
                    <button type="submit">Restore</button>
                </form>
                
                <form method="POST" 
                      action="{{ route('trash.force-delete', ['type' => 'notebook', 'id' => $notebook->id]) }}" 
                      style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('This will permanently delete this notebook. Are you sure?')">
                        Delete Permanently
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
@endif

<h2>Notes</h2>
@if ($notes->isEmpty())
    <p>No deleted notes.</p>
@else
    <ul>
        @foreach ($notes as $note)
            <li>
                {{ $note->title ?: 'Untitled Note' }}
                <small>Deleted {{ $note->deleted_at?->diffForHumans() ?? 'Unknown date' }}</small>
                
                <form method="POST" 
                      action="{{ route('trash.restore', ['type' => 'note', 'id' => $note->id]) }}" 
                      style="display: inline;">
                    @csrf
                    <button type="submit">Restore</button>
                </form>
                
                <form method="POST" 
                      action="{{ route('trash.force-delete', ['type' => 'note', 'id' => $note->id]) }}" 
                      style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            onclick="return confirm('This will permanently delete this note. Are you sure?')">
                        Delete Permanently
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
@endif

@if ($notebooks->isEmpty() && $notes->isEmpty())
    <p>
        <a href="{{ route('dashboard') }}">Back to Dashboard</a>
    </p>
@endif
@endsection