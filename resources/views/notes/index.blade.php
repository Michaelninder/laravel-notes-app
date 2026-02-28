@extends('layouts.app')

@section('content')
<h1>All Notes</h1>

<a href="{{ route('notes.create', [
    'notable_type' => \App\Models\User::class,
    'notable_id' => auth()->id()
]) }}">Create New Note</a>

@if ($notes->isEmpty())
    <p>You don't have any notes yet. Create one to get started!</p>
@else
    <ul>
        @foreach ($notes as $note)
            <li>
                <a href="{{ route('notes.show', $note) }}">
                    {{ $note->title ?: 'Untitled Note' }}
                </a>
                <p>{{ Str::limit(strip_tags($note->content), 100) }}</p>
                <small>
                    @if ($note->notable_type === \App\Models\NoteBook::class)
                        In: {{ $note->notable->name }}
                    @else
                        Personal Note
                    @endif
                    | {{ $note->updated_at->diffForHumans() }}
                </small>
                <a href="{{ route('notes.edit', $note) }}">Edit</a>
            </li>
        @endforeach
    </ul>
@endif
@endsection