@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>All Notes</h1>
    <a href="{{ route('notes.create', [
        'notable_type' => \App\Models\User::class,
        'notable_id'   => auth()->id()
    ]) }}" class="btn btn-primary">
        <i data-lucide="plus" style="width:15px;height:15px;"></i>
        New Note
    </a>
</div>

@if ($notes->isEmpty())
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i data-lucide="file-plus-2" style="width:24px;height:24px;"></i>
            </div>
            <p>You don't have any notes yet.</p>
            <a href="{{ route('notes.create', [
                'notable_type' => \App\Models\User::class,
                'notable_id'   => auth()->id()
            ]) }}" class="btn btn-primary">
                <i data-lucide="plus" style="width:15px;height:15px;"></i>
                Create your first note
            </a>
        </div>
    </div>
@else
    <div class="notes-grid">
        @foreach ($notes as $note)
            @php
                $isInNotebook = $note->notable_type === \App\Models\NoteBook::class;
                $notebookIcon = $isInNotebook && $note->notable?->icon ? $note->notable->icon : null;
            @endphp

            <div class="note-card">
                {{-- Icon: notebook lucide-slug or default file icon --}}
                <div class="note-card-icon">
                    @if ($notebookIcon)
                        <i data-lucide="{{ $notebookIcon }}" style="width:17px;height:17px;"></i>
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
                        @if ($isInNotebook && $note->notable)
                            <span class="tag-badge">
                                @if ($notebookIcon)
                                    <i data-lucide="{{ $notebookIcon }}" style="width:11px;height:11px;"></i>
                                @else
                                    <i data-lucide="book-open" style="width:11px;height:11px;"></i>
                                @endif
                                {{ $note->notable->name }}
                            </span>
                        @else
                            <span class="tag-badge personal">
                                <i data-lucide="user" style="width:11px;height:11px;"></i>
                                Personal
                            </span>
                        @endif
                        <span class="text-muted text-sm">{{ $note->updated_at->diffForHumans() }}</span>
                    </div>
                </div>

                <div class="note-card-actions">
                    <a href="{{ route('notes.edit', $note) }}"
                       class="btn-icon"
                       data-tooltip="Edit note">
                        <i data-lucide="pencil" style="width:15px;height:15px;"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif

@endsection