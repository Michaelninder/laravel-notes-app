@extends('layouts.app')

@section('content')
<h1>Edit Note</h1>

<form method="POST" action="{{ route('notes.update', $note) }}">
    @csrf
    @method('PUT')

    <label for="title">Title (optional)</label>
    <input type="text" 
           id="title" 
           name="title" 
           value="{{ old('title', $note->title) }}">

    <label for="content">Content</label>
    <textarea id="content" 
              name="content" 
              rows="15">{{ old('content', $note->content) }}</textarea>

    <label for="location">Save to:</label>
    <select name="notable_type" id="notable_type" required>
        <option value="{{ \App\Models\User::class }}" 
                {{ old('notable_type', $note->notable_type) === 
                   \App\Models\User::class ? 'selected' : '' }}>
            Personal Notes
        </option>
        @foreach ($notebooks as $notebook)
            <option value="{{ \App\Models\NoteBook::class }}" 
                    data-id="{{ $notebook->id }}"
                    {{ old('notable_type', $note->notable_type) === 
                       \App\Models\NoteBook::class && 
                       old('notable_id', $note->notable_id) === 
                       $notebook->id ? 'selected' : '' }}>
                {{ $notebook->name }}
            </option>
        @endforeach
    </select>

    <input type="hidden" 
           name="notable_id" 
           id="notable_id" 
           value="{{ old('notable_id', $note->notable_id) }}">

    <button type="submit">Update Note</button>
    <a href="{{ route('notes.show', $note) }}">Cancel</a>
</form>

<script>
    document.getElementById('notable_type').addEventListener('change', 
      function(e) {
        const selected = e.target.selectedOptions[0];
        if (selected.value === '{{ \App\Models\User::class }}') {
            document.getElementById('notable_id').value = 
              '{{ auth()->id() }}';
        } else {
            document.getElementById('notable_id').value = 
              selected.dataset.id;
        }
    });
</script>
@endsection