@extends('layouts.app')

@section('content')
<h1>My Notebooks</h1>

<a href="{{ route('notebooks.create') }}">Create New Notebook</a>

@if ($notebooks->isEmpty())
    <p>You don't have any notebooks yet. Create one to get started!</p>
@else
    <ul>
        @foreach ($notebooks as $notebook)
            <li>
                <a href="{{ route('notebooks.show', $notebook) }}">
                    @if ($notebook->icon)
                        <span>{{ $notebook->icon }}</span>
                    @endif
                    {{ $notebook->name }}
                </a>
                <span>({{ $notebook->notes_count }} notes)</span>
                <a href="{{ route('notebooks.edit', $notebook) }}">Edit</a>
                <form method="POST" 
                      action="{{ route('notebooks.destroy', $notebook) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
@endif
@endsection