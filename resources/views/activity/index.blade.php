@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1>Activity Log</h1>
        <p style="margin-bottom:0;font-size:.9rem;">A full record of your recent actions and changes.</p>
    </div>
</div>

@if ($activities->isEmpty())
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i data-lucide="clock" style="width:24px;height:24px;"></i>
            </div>
            <p>No activity recorded yet.</p>
        </div>
    </div>
@else
    <div class="activity-log">
        @foreach ($activities as $activity)
            @php
                $isNote     = $activity->subject_type === \App\Models\Note::class;
                $isNotebook = $activity->subject_type === \App\Models\NoteBook::class;
                $icon       = match(true) {
                    str_contains($activity->description, 'created') => 'plus-circle',
                    str_contains($activity->description, 'updated') => 'pencil',
                    str_contains($activity->description, 'deleted') => 'trash-2',
                    str_contains($activity->description, 'restored') => 'rotate-ccw',
                    default => 'activity',
                };
            @endphp

            <div class="activity-card">
                <div class="activity-card-top">
                    <div class="activity-card-icon">
                        <i data-lucide="{{ $icon }}" style="width:16px;height:16px;"></i>
                    </div>

                    <div class="activity-card-content">
                        <div class="activity-card-title">
                            {{ ucfirst($activity->description) }}
                            <span class="activity-subject-badge">
                                {{ class_basename($activity->subject_type) }}
                            </span>
                        </div>
                        <div class="activity-card-meta">
                            <i data-lucide="clock" style="width:11px;height:11px;"></i>
                            {{ $activity->created_at->format('M d, Y · H:i') }}
                            <span class="text-muted">· {{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    <div class="activity-card-actions">
                        @if ($activity->subject)
                            @php
                                $viewUrl = $isNote
                                    ? route('notes.show', $activity->subject_id)
                                    : ($isNotebook ? route('notebooks.show', $activity->subject_id) : null);
                            @endphp
                            @if ($viewUrl)
                                <a href="{{ $viewUrl }}" class="btn btn-ghost btn-sm" data-tooltip="View">
                                    <i data-lucide="arrow-up-right" style="width:13px;height:13px;"></i>
                                    View
                                </a>
                            @endif
                        @endif
                    </div>
                </div>

                @if ($activity->properties->isNotEmpty())
                    <details>
                        <summary>Show details</summary>
                        <pre>{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</pre>
                    </details>
                @endif
            </div>
        @endforeach
    </div>

    <div class="pagination-wrap">
        {{ $activities->links() }}
    </div>
@endif

@endsection