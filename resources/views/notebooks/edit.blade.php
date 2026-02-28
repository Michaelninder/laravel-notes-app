@extends('layouts.app')

@section('content')
<h1>Edit Notebook</h1>

<form method="POST" action="{{ route('notebooks.update', $notebook) }}">
    @csrf
    @method('PUT')

    <label for="name">Notebook Name</label>
    <input type="text" 
           id="name" 
           name="name" 
           value="{{ old('name', $notebook->name) }}" 
           required>

    <label for="icon">Icon (Lucide icon name, optional)</label>
    <input type="text" 
           id="icon" 
           name="icon" 
           value="{{ old('icon', $notebook->icon) }}"
           placeholder="e.g., book-open">

    <button type="submit">Update Notebook</button>
    <a href="{{ route('notebooks.show', $notebook) }}">Cancel</a>
</form>
@endsection