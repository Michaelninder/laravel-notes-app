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
            <label>
                <i data-lucide="folder" style="width:13px;height:13px;vertical-align:middle;"></i>
                Save to
            </label>
            <x-notebook-select
                :notableType="old('notable_type', $note->notable_type)"
                :notableId="old('notable_id', $note->notable_id)"
                :notebooks="$notebooks"
                :userId="auth()->id()"
            />
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