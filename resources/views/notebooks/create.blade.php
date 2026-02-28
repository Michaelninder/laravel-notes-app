@extends('layouts.app')

@section('content')
<h1>Create New Notebook</h1>

<form method="POST" action="{{ route('notebooks.store') }}">
    @csrf

    <label for="name">Notebook Name</label>
    <input type="text" 
           id="name" 
           name="name" 
           value="{{ old('name') }}" 
           required>

    <label for="icon">Icon (Lucide icon name, optional)</label>
    <input type="text" 
           id="icon" 
           name="icon" 
           value="{{ old('icon') }}"
           placeholder="e.g., book-open">

    <button type="submit">Create Notebook</button>
    <a href="{{ route('notebooks.index') }}">Cancel</a>
</form>
@endsection