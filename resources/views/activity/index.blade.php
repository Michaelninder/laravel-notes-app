@extends('layouts.app')

@section('content')
<h1>Activity Log</h1>

<p>View all your recent actions and changes.</p>

@if ($activities->isEmpty())
    <p>No activity recorded yet.</p>
@else
    <ul>
        @foreach ($activities as $activity)
            <li>
                <div>
                    <strong>{{ ucfirst($activity->description) }}</strong>
                    <span>{{ class_basename($activity->subject_type) }}</span>
                    @if ($activity->subject)
                        <a href="{{ $activity->subject_type === \App\Models\Note::class 
                            ? route('notes.show', $activity->subject_id) 
                            : route('notebooks.show', $activity->subject_id) }}">
                            View
                        </a>
                    @endif
                </div>
                <div>
                    <small>{{ $activity->created_at->format('M d, Y H:i') }}</small>
                    <small>({{ $activity->created_at->diffForHumans() }})</small>
                </div>
                @if ($activity->properties->isNotEmpty())
                    <details>
                        <summary>Show details</summary>
                        <pre>{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                    </details>
                @endif
            </li>
        @endforeach
    </ul>

    {{ $activities->links() }}
@endif
@endsection