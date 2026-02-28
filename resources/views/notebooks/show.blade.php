@extends('layouts.app')

@section('content')
<h1>
    @if ($notebook->icon)
        <span>{{ $notebook->icon }}</span>
    @endif
    {{ $notebook->name }}
</h1>

<a href="{{ route('notebooks.edit', $notebook) }}">Edit Notebook</a>
<a href="{{ route('notes.create', [
    'notable_type' => get_class($notebook), 
    'notable_id' => $notebook->id
]) }}">Add Note</a>

@if ($notebook->notes->isEmpty())
    <p>This notebook is empty. Create a note to get started!</p>
@else
    <ul>
        @foreach ($notebook->notes as $note)
            <li>
                <a href="{{ route('notes.show', $note) }}">
                    {{ $note->title ?: 'Untitled Note' }}
                </a>
                <p>{{ Str::limit(strip_tags($note->content), 100) }}</p>
                <small>{{ $note->updated_at->diffForHumans() }}</small>
            </li>
        @endforeach
    </ul>
@endif
@endsection