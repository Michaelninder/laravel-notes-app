@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>
        <i data-lucide="pencil" style="width:20px;height:20px;color:var(--accent);vertical-align:middle;margin-right:.35rem;"></i>
        Edit Note
    </h1>
    <a href="{{ route('notes.show', $note) }}" class="btn btn-ghost btn-sm">
        <i data-lucide="arrow-left" style="width:13px;height:13px;"></i>
        Cancel
    </a>
</div>

<form method="POST" action="{{ route('notes.update', $note) }}">
    @csrf
    @method('PUT')

    <div class="form-card">
        <div class="form-group">
            <label for="title">Title <span class="text-muted text-sm">(optional)</span></label>
            <input type="text"
                   id="title"
                   name="title"
                   value="{{ old('title', $note->title) }}"
                   placeholder="Give your note a title…"
                   autofocus>
        </div>

        <div class="form-group">
            <label for="notable_type">
                <i data-lucide="folder" style="width:13px;height:13px;vertical-align:middle;"></i>
                Save to
            </label>
            <select name="notable_type" id="notable_type" required>
                <option value="{{ \App\Models\User::class }}"
                        data-id="{{ auth()->id() }}"
                        {{ old('notable_type', $note->notable_type) === \App\Models\User::class ? 'selected' : '' }}>
                    📁 Personal Notes
                </option>
                @foreach ($notebooks as $notebook)
                    <option value="{{ \App\Models\NoteBook::class }}"
                            data-id="{{ $notebook->id }}"
                            {{ old('notable_type', $note->notable_type) === \App\Models\NoteBook::class &&
                               (int) old('notable_id', $note->notable_id) === $notebook->id ? 'selected' : '' }}>
                        {{ $notebook->name }}
                    </option>
                @endforeach
            </select>

            <input type="hidden"
                   name="notable_id"
                   id="notable_id"
                   value="{{ old('notable_id', $note->notable_id) }}"
                   data-user-id="{{ auth()->id() }}">
        </div>

        <div class="form-group" style="margin-bottom:0;">
            <label for="content">Content</label>
            <textarea id="content"
                      name="content"
                      class="note-editor">{{ old('content', $note->content) }}</textarea>
        </div>
    </div>

    <div class="form-actions" style="margin-top:1.25rem;">
        <button type="submit" class="btn btn-primary">
            <i data-lucide="save" style="width:15px;height:15px;"></i>
            Save Changes
        </button>
        <a href="{{ route('notes.show', $note) }}" class="btn btn-ghost">Cancel</a>
    </div>
</form>

@endsection