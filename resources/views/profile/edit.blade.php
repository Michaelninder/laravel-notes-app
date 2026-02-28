@extends('layouts.app')

@section('content')
<h1>Profile Settings</h1>

<section>
    <h2>Update Profile Information</h2>
    
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div>
            <label for="name">Name</label>
            <input type="text" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', auth()->user()->name) }}" 
                   required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   value="{{ old('email', auth()->user()->email) }}" 
                   required>
        </div>

        <button type="submit">Save Changes</button>
    </form>
</section>

<hr>

<section>
    <h2>Update Password</h2>
    
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('PUT')

        <div>
            <label for="current_password">Current Password</label>
            <input type="password" 
                   id="current_password" 
                   name="current_password" 
                   required>
        </div>

        <div>
            <label for="password">New Password</label>
            <input type="password" 
                   id="password" 
                   name="password" 
                   required>
        </div>

        <div>
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   required>
        </div>

        <button type="submit">Update Password</button>
    </form>
</section>

<hr>

<section>
    <h2>Delete Account</h2>
    
    <p>
        Once your account is deleted, all of its resources and data 
        will be permanently deleted.
    </p>
    
    <form method="POST" action="{{ route('profile.destroy') }}">
        @csrf
        @method('DELETE')

        <div>
            <label for="password_delete">Confirm Password</label>
            <input type="password" 
                   id="password_delete" 
                   name="password" 
                   required>
        </div>

        <button type="submit" 
                onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
            Delete Account
        </button>
    </form>
</section>
@endsection