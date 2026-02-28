<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel Notes') }}</title>
</head>
<body>
    @auth
    <header>
        <nav>
            <div>
                <a href="{{ route('dashboard') }}">
                    <strong>{{ config('app.name', 'Laravel Notes') }}</strong>
                </a>
            </div>
            
            <div>
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('notebooks.index') }}">Notebooks</a>
                <a href="{{ route('notes.index') }}">All Notes</a>
                <a href="{{ route('activity.index') }}">Activity</a>
                <a href="{{ route('trash.index') }}">Trash</a>
            </div>
            
            <div>
                <span>{{ auth()->user()->name }}</span>
                <a href="{{ route('profile.edit') }}">Profile</a>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit">Logout</button>
                </form>
            </div>
        </nav>
    </header>
    @endauth

    <main>
        @if (session('success'))
            <div role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @auth
    {{--<footer>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </footer>--}}
    @endauth
</body>
</html>