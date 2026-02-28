@extends('layouts.app')

@section('content')
<h1>Dashboard</h1>

<div>
    <h2>Quick Stats</h2>
    <ul>
        <li>Total Notebooks: {{ auth()->user()->noteBooks()->count() }}</li>
        <li>Total Notes: {{ $totalNotes }}</li>
        <li>Recent Activity: {{ $recentActivities->count() }} events</li>
    </ul>
</div>

<div>
    <h2>Recent Notes</h2>
    @if ($recentNotes->isEmpty())
        <p>No notes yet. <a href="{{ route('notes.create', [
            'notable_type' => \App\Models\User::class,
            'notable_id' => auth()->id()
        ]) }}">Create your first note</a></p>
    @else
        <ul>
            @foreach ($recentNotes as $note)
                <li>
                    <a href="{{ route('notes.show', $note) }}">
                        {{ $note->title ?: 'Untitled Note' }}
                    </a>
                    <small>{{ $note->updated_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('notes.index') }}">View all notes</a>
    @endif
</div>

<div>
    <h2>Recent Notebooks</h2>
    @if ($recentNotebooks->isEmpty())
        <p>No notebooks yet. 
           <a href="{{ route('notebooks.create') }}">Create your first notebook</a>
        </p>
    @else
        <ul>
            @foreach ($recentNotebooks as $notebook)
                <li>
                    <a href="{{ route('notebooks.show', $notebook) }}">
                        @if ($notebook->icon)
                            <span>{{ $notebook->icon }}</span>
                        @endif
                        {{ $notebook->name }}
                    </a>
                    <small>({{ $notebook->notes_count }} notes)</small>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('notebooks.index') }}">View all notebooks</a>
    @endif
</div>

<div>
    <h2>Recent Activity</h2>
    @if ($recentActivities->isEmpty())
        <p>No recent activity.</p>
    @else
        <ul>
            @foreach ($recentActivities as $activity)
                <li>
                    <strong>{{ $activity->description }}</strong>
                    on {{ $activity->subject_type }}
                    <small>{{ $activity->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('activity.index') }}">View all activity</a>
    @endif
</div>
@endsection