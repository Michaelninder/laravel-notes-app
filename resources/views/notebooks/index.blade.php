@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>My Notebooks</h1>
    <a href="{{ route('notebooks.create') }}" class="btn btn-primary">
        <i data-lucide="plus" style="width:15px;height:15px;"></i>
        New Notebook
    </a>
</div>

@if ($notebooks->isEmpty())
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">
                <i data-lucide="book-plus" style="width:24px;height:24px;"></i>
            </div>
            <p>You don't have any notebooks yet.</p>
            <a href="{{ route('notebooks.create') }}" class="btn btn-primary">
                <i data-lucide="plus" style="width:15px;height:15px;"></i>
                Create your first notebook
            </a>
        </div>
    </div>
@else
    <div class="notebooks-grid">
        @foreach ($notebooks as $notebook)
            <div class="notebook-card">
                {{-- Icon --}}
                <div class="notebook-card-icon">
                    @if ($notebook->icon)
                        <i data-lucide="{{ $notebook->icon }}" style="width:20px;height:20px;"></i>
                    @else
                        <i data-lucide="book-open" style="width:20px;height:20px;"></i>
                    @endif
                </div>

                {{-- Name + count --}}
                <div>
                    <a href="{{ route('notebooks.show', $notebook) }}" class="notebook-card-name">
                        {{ $notebook->name }}
                    </a>
                    <div class="notebook-card-count">
                        {{ $notebook->notes_count }} {{ Str::plural('note', $notebook->notes_count) }}
                    </div>
                </div>

                {{-- Actions --}}
                <div class="notebook-card-actions">
                    <a href="{{ route('notebooks.show', $notebook) }}"
                       class="btn btn-ghost btn-sm" style="flex:1;justify-content:center;">
                        <i data-lucide="eye" style="width:13px;height:13px;"></i>
                        Open
                    </a>
                    <a href="{{ route('notebooks.edit', $notebook) }}"
                       class="btn-icon" data-tooltip="Edit">
                        <i data-lucide="pencil" style="width:15px;height:15px;"></i>
                    </a>
                    <button type="button"
                            class="btn-icon danger"
                            data-modal-open="modal-del-nb-{{ $notebook->id }}"
                            data-tooltip="Delete">
                        <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
                    </button>
                </div>
            </div>

            {{-- Delete modal --}}
            <div class="modal-overlay" id="modal-del-nb-{{ $notebook->id }}" role="dialog" aria-modal="true">
                <div class="modal">
                    <div class="modal-header">
                        <h3>Delete Notebook?</h3>
                        <button class="btn-icon" data-modal-close aria-label="Close">
                            <i data-lucide="x" style="width:16px;height:16px;"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Are you sure you want to delete
                            <strong>{{ $notebook->name }}</strong>?
                            The notebook will be moved to trash.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost" data-modal-close>Cancel</button>
                        <form method="POST" action="{{ route('notebooks.destroy', $notebook) }}">
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
        @endforeach
    </div>
@endif

@endsection