@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>Dashboard</h1>
    <a href="{{ route('notes.create', [
        'notable_type' => \App\Models\User::class,
        'notable_id'   => auth()->id()
    ]) }}" class="btn btn-primary">
        <i data-lucide="plus" style="width:15px;height:15px;"></i>
        New Note
    </a>
</div>

{{-- Quick Stats --}}
<div class="stats-grid">
    <div class="stat-item">
        <div class="stat-icon">
            <i data-lucide="book-open" style="width:18px;height:18px;"></i>
        </div>
        <div>
            <div class="stat-number">{{ auth()->user()->noteBooks()->count() }}</div>
            <div class="stat-label">Notebooks</div>
        </div>
    </div>
    <div class="stat-item">
        <div class="stat-icon">
            <i data-lucide="file-text" style="width:18px;height:18px;"></i>
        </div>
        <div>
            <div class="stat-number">{{ $totalNotes }}</div>
            <div class="stat-label">Total Notes</div>
        </div>
    </div>
    <div class="stat-item">
        <div class="stat-icon">
            <i data-lucide="activity" style="width:18px;height:18px;"></i>
        </div>
        <div>
            <div class="stat-number">{{ $recentActivities->count() }}</div>
            <div class="stat-label">Recent Events</div>
        </div>
    </div>
</div>

{{-- Main grid --}}
<div class="dashboard-grid">

    {{-- Recent Notes --}}
    <div class="card">
        <div class="card-header">
            <h2>
                <i data-lucide="file-text" style="width:16px;height:16px;color:var(--ink-3);vertical-align:middle;margin-right:.3rem;"></i>
                Recent Notes
            </h2>
            <a href="{{ route('notes.index') }}" class="btn btn-ghost btn-sm">
                View all
                <i data-lucide="arrow-right" style="width:13px;height:13px;"></i>
            </a>
        </div>

        @if ($recentNotes->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i data-lucide="file-plus-2" style="width:22px;height:22px;"></i>
                </div>
                <p>No notes yet.</p>
                <a href="{{ route('notes.create', [
                    'notable_type' => \App\Models\User::class,
                    'notable_id'   => auth()->id()
                ]) }}" class="btn btn-primary btn-sm">
                    <i data-lucide="plus" style="width:13px;height:13px;"></i>
                    Create first note
                </a>
            </div>
        @else
            <div class="item-list">
                @foreach ($recentNotes as $note)
                    <a href="{{ route('notes.show', $note) }}" class="item-row">
                        <div class="item-icon">
                            <i data-lucide="file-text" style="width:15px;height:15px;"></i>
                        </div>
                        <div class="item-content">
                            <span class="item-title">{{ $note->title ?: 'Untitled Note' }}</span>
                            <div class="item-meta">{{ $note->updated_at->diffForHumans() }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Recent Notebooks --}}
    <div class="card">
        <div class="card-header">
            <h2>
                <i data-lucide="book-open" style="width:16px;height:16px;color:var(--ink-3);vertical-align:middle;margin-right:.3rem;"></i>
                Recent Notebooks
            </h2>
            <a href="{{ route('notebooks.index') }}" class="btn btn-ghost btn-sm">
                View all
                <i data-lucide="arrow-right" style="width:13px;height:13px;"></i>
            </a>
        </div>

        @if ($recentNotebooks->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i data-lucide="book-plus" style="width:22px;height:22px;"></i>
                </div>
                <p>No notebooks yet.</p>
                <a href="{{ route('notebooks.create') }}" class="btn btn-primary btn-sm">
                    <i data-lucide="plus" style="width:13px;height:13px;"></i>
                    Create notebook
                </a>
            </div>
        @else
            <div class="item-list">
                @foreach ($recentNotebooks as $notebook)
                    <a href="{{ route('notebooks.show', $notebook) }}" class="item-row">
                        <div class="item-icon notebook-icon">
                            @if ($notebook->icon)
                                <i data-lucide="{{ $notebook->icon }}" style="width:15px;height:15px;"></i>
                            @else
                                <i data-lucide="book-open" style="width:15px;height:15px;"></i>
                            @endif
                        </div>
                        <div class="item-content">
                            <span class="item-title">{{ $notebook->name }}</span>
                            <div class="item-meta">{{ $notebook->notes_count }} {{ Str::plural('note', $notebook->notes_count) }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Recent Activity (full width) --}}
    <div class="card card-full">
        <div class="card-header">
            <h2>
                <i data-lucide="activity" style="width:16px;height:16px;color:var(--ink-3);vertical-align:middle;margin-right:.3rem;"></i>
                Recent Activity
            </h2>
            <a href="{{ route('activity.index') }}" class="btn btn-ghost btn-sm">
                View all
                <i data-lucide="arrow-right" style="width:13px;height:13px;"></i>
            </a>
        </div>

        @if ($recentActivities->isEmpty())
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i data-lucide="clock" style="width:22px;height:22px;"></i>
                </div>
                <p>No recent activity.</p>
            </div>
        @else
            @foreach ($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-dot"></div>
                    <div>
                        <div class="activity-text">
                            <strong>{{ $activity->description }}</strong>
                            <span class="text-muted"> · {{ class_basename($activity->subject_type) }}</span>
                        </div>
                        <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

</div>

@endsection