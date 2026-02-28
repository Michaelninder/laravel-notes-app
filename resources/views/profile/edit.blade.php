@extends('layouts.app')

@section('content')

<div class="page-header">
    <h1>Profile Settings</h1>
</div>

{{-- Update Profile --}}
<div class="profile-section">
    <h2>
        <i data-lucide="user-pen" style="width:17px;height:17px;color:var(--accent);"></i>
        Profile Information
    </h2>

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text"
                   id="name"
                   name="name"
                   value="{{ old('name', auth()->user()->name) }}"
                   required
                   placeholder="Your full name">
        </div>

        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email"
                   id="email"
                   name="email"
                   value="{{ old('email', auth()->user()->email) }}"
                   required
                   placeholder="you@example.com">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="save" style="width:15px;height:15px;"></i>
                Save Changes
            </button>
        </div>
    </form>
</div>

{{-- Update Password --}}
<div class="profile-section">
    <h2>
        <i data-lucide="lock-keyhole" style="width:17px;height:17px;color:var(--accent);"></i>
        Update Password
    </h2>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password"
                   id="current_password"
                   name="current_password"
                   required
                   placeholder="••••••••">
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password"
                   id="password"
                   name="password"
                   required
                   placeholder="••••••••">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password"
                   id="password_confirmation"
                   name="password_confirmation"
                   required
                   placeholder="••••••••">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <i data-lucide="shield-check" style="width:15px;height:15px;"></i>
                Update Password
            </button>
        </div>
    </form>
</div>

{{-- Delete Account --}}
<div class="profile-section danger-zone">
    <h2>
        <i data-lucide="triangle-alert" style="width:17px;height:17px;"></i>
        Delete Account
    </h2>

    <p>Once your account is deleted, all notebooks, notes, and data will be <strong>permanently removed</strong> and cannot be recovered.</p>

    <button type="button" class="btn btn-danger" data-modal-open="modal-delete-account">
        <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
        Delete My Account
    </button>
</div>

{{-- Delete account modal --}}
<div class="modal-overlay" id="modal-delete-account" role="dialog" aria-modal="true" aria-labelledby="modal-delete-title">
    <div class="modal">
        <div class="modal-header">
            <h3 id="modal-delete-title">Confirm Account Deletion</h3>
            <button class="btn-icon" data-modal-close aria-label="Close">
                <i data-lucide="x" style="width:16px;height:16px;"></i>
            </button>
        </div>
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="modal-body">
                <p>This will permanently delete your account and all associated data. This action <strong>cannot be undone</strong>.</p>
                <div class="form-group" style="margin-top:1rem;">
                    <label for="password_delete">Enter your password to confirm</label>
                    <input type="password"
                           id="password_delete"
                           name="password"
                           required
                           placeholder="••••••••"
                           autofocus>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-ghost" data-modal-close>Cancel</button>
                <button type="submit" class="btn btn-danger">
                    <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>

@endsection