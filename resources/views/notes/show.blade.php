@extends('layouts.app')

@section('content')
<h1>{{ $note->title ?: 'Untitled Note' }}</h1>

<div>
    @if ($note->notable_type === \App\Models\NoteBook::class)
        <a href="{{ route('notebooks.show', $note->notable) }}">
            {{ $note->notable->name }}
        </a>
    @else
        <span>Personal Note</span>
    @endif
    | Last updated: {{ $note->updated_at->diffForHumans() }}
</div>

<a href="{{ route('notes.edit', $note) }}">Edit</a>

<form method="POST" action="{{ route('notes.destroy', $note) }}">
    @csrf
    @method('DELETE')
    <button type="submit">Delete</button>
</form>

<hr>

<div>
    {!! nl2br(e($note->content)) !!}
</div>
@endsection