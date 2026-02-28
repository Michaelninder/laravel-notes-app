@extends('layouts.app')

@section('content')

{{-- Notebook header --}}
<div class="notebook-show-header">
    <div class="notebook-show-icon">
        @if ($notebook->icon)
            <i data-lucide="{{ $notebook->icon }}" style="width:24px;height:24px;"></i>
        @else
            <i data-lucide="book-open" style="width:24px;height:24px;"></i>
        @endif
    </div>

    <div class="notebook-show-title">
        <h1>{{ $notebook->name }}</h1>
        <div class="note-show-meta">
            <i data-lucide="file-text" style="width:12px;height:12px;"></i>
            <span>{{ $notebook->notes->count() }} {{ Str::plural('note', $notebook->notes->count()) }}</span>
            <span class="meta-sep">·</span>
            <i data-lucide="calendar" style="width:12px;height:12px;"></i>
            <span>Created {{ $notebook->created_at->format('M d, Y') }}</span>
        </div>
    </div>

    <div class="notebook-show-actions">
        <a href="{{ route('notes.create', [
            'notable_type' => get_class($notebook),
            'notable_id'   => $notebook->id
        ]) }}" class="btn btn-primary btn-sm">
            <i data-lucide="plus" style="width:13px;height:13px;"></i>
            Add Note
        </a>
        <a href="{{ route('notebooks.edit', $notebook) }}" class="btn btn-ghost btn-sm" data-tooltip="Edit notebook">
            <i data-lucide="settings-2" style="width:14px;height:14px;"></i>
        </a>
    </div>
</div>

{{-- Notes --}}
@if ($notebook->notes->isEmpty())
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i data-lucide="file-plus-2" style="width:24px;height:24px;"></i>
            </div>
            <p>This notebook is empty.</p>
            <a href="{{ route('notes.create', [
                'notable_type' => get_class($notebook),
                'notable_id'   => $notebook->id
            ]) }}" class="btn btn-primary">
                <i data-lucide="plus" style="width:15px;height:15px;"></i>
                Create first note
            </a>
        </div>
    </div>
@else
    <div class="notes-grid">
        @foreach ($notebook->notes as $note)
            <div class="note-card">
                <div class="note-card-icon">
                    @if ($notebook->icon)
                        <i data-lucide="{{ $notebook->icon }}" style="width:17px;height:17px;"></i>
                    @else
                        <i data-lucide="file-text" style="width:17px;height:17px;"></i>
                    @endif
                </div>

                <div class="note-card-body">
                    <a href="{{ route('notes.show', $note) }}" class="note-card-title" style="display:block;text-decoration:none;color:inherit;">
                        {{ $note->title ?: 'Untitled Note' }}
                    </a>
                    @if ($note->content)
                        <p class="note-card-excerpt">{{ Str::limit(strip_tags($note->content), 120) }}</p>
                    @endif
                    <div class="note-card-footer">
                        <span class="text-muted text-sm">
                            <i data-lucide="clock" style="width:11px;height:11px;vertical-align:middle;"></i>
                            {{ $note->updated_at->diffForHumans() }}
                        </span>
                    </div>
                </div>

                <div class="note-card-actions">
                    <a href="{{ route('notes.edit', $note) }}" class="btn-icon" data-tooltip="Edit">
                        <i data-lucide="pencil" style="width:15px;height:15px;"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Back --}}
<div style="margin-top:1.5rem;">
    <a href="{{ route('notebooks.index') }}" class="btn btn-ghost btn-sm">
        <i data-lucide="arrow-left" style="width:13px;height:13px;"></i>
        All Notebooks
    </a>
</div>

@endsection