@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>
        <i data-lucide="book-plus" style="width:20px;height:20px;color:var(--accent);vertical-align:middle;margin-right:.35rem;"></i>
        Create Notebook
    </h1>
    <a href="{{ route('notebooks.index') }}" class="btn btn-ghost btn-sm">
        <i data-lucide="arrow-left" style="width:13px;height:13px;"></i>
        Cancel
    </a>
</div>

<form method="POST" action="{{ route('notebooks.store') }}">
    @csrf

    <div class="form-card">
        <div class="form-group">
            <label for="name">Notebook Name</label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="e.g. Work, Personal, Research…"
                   required
                   autofocus>
        </div>

        <hr class="divider">

        <x-icon-picker name="icon" :selected="old('icon', '')" label="Notebook Icon" />
    </div>

    <div class="form-actions" style="margin-top:1.25rem;">
        <button type="submit" class="btn btn-primary">
            <i data-lucide="save" style="width:15px;height:15px;"></i>
            Create Notebook
        </button>
        <a href="{{ route('notebooks.index') }}" class="btn btn-ghost">Cancel</a>
    </div>
</form>

@endsection