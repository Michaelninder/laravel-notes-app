@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h1>Trash</h1>
        <p style="margin-bottom:0;font-size:.9rem;color:var(--ink-3);">
            <i data-lucide="clock" style="width:13px;height:13px;vertical-align:middle;"></i>
            Deleted items are kept for 30 days before being permanently removed.
        </p>
    </div>
</div>

@if ($notebooks->isEmpty() && $notes->isEmpty())
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i data-lucide="trash-2" style="width:24px;height:24px;"></i>
            </div>
            <p>Your trash is empty — nothing to see here.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">
                <i data-lucide="arrow-left" style="width:13px;height:13px;"></i>
                Back to Dashboard
            </a>
        </div>
    </div>
@else

    {{-- ── Notebooks ─────────────────────────────────────────── --}}
    <div class="trash-section">
        <div class="trash-section-header">
            <i data-lucide="book-open" style="width:16px;height:16px;color:var(--ink-3);"></i>
            <h2>Notebooks</h2>
            <span class="trash-count">{{ $notebooks->count() }}</span>
        </div>

        @if ($notebooks->isEmpty())
            <p class="text-muted text-sm" style="padding:.5rem 0;">No deleted notebooks.</p>
        @else
            @foreach ($notebooks as $notebook)
                <div class="trash-item">
                    <div class="trash-item-icon">
                        @if ($notebook->icon)
                            <i data-lucide="{{ $notebook->icon }}" style="width:16px;height:16px;"></i>
                        @else
                            <i data-lucide="book-open" style="width:16px;height:16px;"></i>
                        @endif
                    </div>

                    <div class="trash-item-content">
                        <div class="trash-item-title">{{ $notebook->name }}</div>
                        <div class="trash-item-meta">
                            <i data-lucide="trash" style="width:11px;height:11px;"></i>
                            Deleted {{ $notebook->deleted_at?->diffForHumans() ?? 'Unknown date' }}
                        </div>
                    </div>

                    <div class="trash-item-actions">
                        {{-- Restore --}}
                        <form method="POST"
                              action="{{ route('trash.restore', ['type' => 'notebook', 'id' => $notebook->id]) }}"
                              class="form-inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm" data-tooltip="Restore notebook">
                                <i data-lucide="rotate-ccw" style="width:13px;height:13px;"></i>
                                Restore
                            </button>
                        </form>

                        {{-- Permanent delete via modal --}}
                        <button type="button"
                                class="btn-icon danger"
                                data-modal-open="modal-del-notebook-{{ $notebook->id }}"
                                data-tooltip="Delete permanently">
                            <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
                        </button>
                    </div>
                </div>

                {{-- Confirm permanent delete modal --}}
                <div class="modal-overlay" id="modal-del-notebook-{{ $notebook->id }}" role="dialog" aria-modal="true">
                    <div class="modal">
                        <div class="modal-header">
                            <h3>Delete Permanently?</h3>
                            <button class="btn-icon" data-modal-close aria-label="Close">
                                <i data-lucide="x" style="width:16px;height:16px;"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                                <strong>{{ $notebook->name }}</strong> and all its notes will be
                                <strong>permanently deleted</strong>. This cannot be undone.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost" data-modal-close>Cancel</button>
                            <form method="POST"
                                  action="{{ route('trash.force-delete', ['type' => 'notebook', 'id' => $notebook->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                    Delete Forever
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- ── Notes ─────────────────────────────────────────────── --}}
    <div class="trash-section">
        <div class="trash-section-header">
            <i data-lucide="file-text" style="width:16px;height:16px;color:var(--ink-3);"></i>
            <h2>Notes</h2>
            <span class="trash-count">{{ $notes->count() }}</span>
        </div>

        @if ($notes->isEmpty())
            <p class="text-muted text-sm" style="padding:.5rem 0;">No deleted notes.</p>
        @else
            @foreach ($notes as $note)
                <div class="trash-item">
                    <div class="trash-item-icon">
                        <i data-lucide="file-text" style="width:16px;height:16px;"></i>
                    </div>

                    <div class="trash-item-content">
                        <div class="trash-item-title">{{ $note->title ?: 'Untitled Note' }}</div>
                        <div class="trash-item-meta">
                            <i data-lucide="trash" style="width:11px;height:11px;"></i>
                            Deleted {{ $note->deleted_at?->diffForHumans() ?? 'Unknown date' }}
                        </div>
                    </div>

                    <div class="trash-item-actions">
                        {{-- Restore --}}
                        <form method="POST"
                              action="{{ route('trash.restore', ['type' => 'note', 'id' => $note->id]) }}"
                              class="form-inline">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm" data-tooltip="Restore note">
                                <i data-lucide="rotate-ccw" style="width:13px;height:13px;"></i>
                                Restore
                            </button>
                        </form>

                        {{-- Permanent delete via modal --}}
                        <button type="button"
                                class="btn-icon danger"
                                data-modal-open="modal-del-note-{{ $note->id }}"
                                data-tooltip="Delete permanently">
                            <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
                        </button>
                    </div>
                </div>

                {{-- Confirm permanent delete modal --}}
                <div class="modal-overlay" id="modal-del-note-{{ $note->id }}" role="dialog" aria-modal="true">
                    <div class="modal">
                        <div class="modal-header">
                            <h3>Delete Permanently?</h3>
                            <button class="btn-icon" data-modal-close aria-label="Close">
                                <i data-lucide="x" style="width:16px;height:16px;"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>
                                <strong>{{ $note->title ?: 'Untitled Note' }}</strong> will be
                                <strong>permanently deleted</strong>. This cannot be undone.
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost" data-modal-close>Cancel</button>
                            <form method="POST"
                                  action="{{ route('trash.force-delete', ['type' => 'note', 'id' => $note->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                    Delete Forever
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

@endif

@endsection