@extends('layouts.app')

@section('content')

<div class="note-show-header">
    <div>
        <h1 style="margin-bottom:.3rem;">{{ $note->title ?: 'Untitled Note' }}</h1>
        <div class="note-show-meta">
            @if ($note->notable_type === \App\Models\NoteBook::class && $note->notable)
                <i data-lucide="{{ $note->notable->icon ?: 'book-open' }}" style="width:13px;height:13px;color:var(--accent);"></i>
                <a href="{{ route('notebooks.show', $note->notable) }}">{{ $note->notable->name }}</a>
            @else
                <i data-lucide="user" style="width:13px;height:13px;"></i>
                <span>Personal Note</span>
            @endif
            <span class="meta-sep">·</span>
            <i data-lucide="clock" style="width:12px;height:12px;"></i>
            <span>Updated {{ $note->updated_at->diffForHumans() }}</span>
            <span class="meta-sep">·</span>
            <span>{{ $note->created_at->format('M d, Y') }}</span>
        </div>
    </div>

    <div class="note-show-actions">
        <a href="{{ route('notes.edit', $note) }}" class="btn btn-ghost btn-sm" data-tooltip="Edit note">
            <i data-lucide="pencil" style="width:14px;height:14px;"></i>
            Edit
        </a>
        <button type="button"
                class="btn-icon danger"
                data-modal-open="modal-delete-note"
                data-tooltip="Delete note">
            <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
        </button>
    </div>
</div>

{{-- Content --}}
<div class="note-content">
    @if ($note->content)
        {!! nl2br(e($note->content)) !!}
    @endif
</div>

{{-- Back link --}}
<div style="margin-top:1.5rem;">
    @if ($note->notable_type === \App\Models\NoteBook::class && $note->notable)
        <a href="{{ route('notebooks.show', $note->notable) }}" class="btn btn-ghost btn-sm">
            <i data-lucide="arrow-left" style="width:13px;height:13px;"></i>
            Back to {{ $note->notable->name }}
        </a>
    @else
        <a href="{{ route('notes.index') }}" class="btn btn-ghost btn-sm">
            <i data-lucide="arrow-left" style="width:13px;height:13px;"></i>
            All Notes
        </a>
    @endif
</div>

{{-- Delete modal --}}
<div class="modal-overlay" id="modal-delete-note" role="dialog" aria-modal="true">
    <div class="modal">
        <div class="modal-header">
            <h3>Delete Note?</h3>
            <button class="btn-icon" data-modal-close aria-label="Close">
                <i data-lucide="x" style="width:16px;height:16px;"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>
                <strong>{{ $note->title ?: 'Untitled Note' }}</strong> will be moved to trash.
                You can restore it within 30 days.
            </p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-ghost" data-modal-close>Cancel</button>
            <form method="POST" action="{{ route('notes.destroy', $note) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                    Move to Trash
                </button>
            </form>
        </div>
    </div>
</div>

@endsection