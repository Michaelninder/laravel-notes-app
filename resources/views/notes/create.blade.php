@extends('layouts.app')

@section('content')
<h1>Create New Note</h1>

<form method="POST" action="{{ route('notes.store') }}">
    @csrf

    <label for="title">Title (optional)</label>
    <input type="text" 
           id="title" 
           name="title" 
           value="{{ old('title') }}">

    <label for="content">Content</label>
    <textarea id="content" 
              name="content" 
              rows="15">{{ old('content') }}</textarea>

    <label for="location">Save to:</label>
    <select name="notable_type" id="notable_type" required>
        <option value="{{ \App\Models\User::class }}" 
                {{ old('notable_type', $notableType) === 
                   \App\Models\User::class ? 'selected' : '' }}>
            Personal Notes
        </option>
        @foreach ($notebooks as $notebook)
            <option value="{{ \App\Models\NoteBook::class }}" 
                    data-id="{{ $notebook->id }}"
                    {{ old('notable_type', $notableType) === 
                       \App\Models\NoteBook::class && 
                       old('notable_id', $notableId) === $notebook->id 
                       ? 'selected' : '' }}>
                {{ $notebook->name }}
            </option>
        @endforeach
    </select>

    <input type="hidden" 
           name="notable_id" 
           id="notable_id" 
           value="{{ old('notable_id', $notableId ?? auth()->id()) }}">

    <button type="submit">Create Note</button>
    <a href="{{ route('notes.index') }}">Cancel</a>
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