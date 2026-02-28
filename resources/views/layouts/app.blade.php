<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel Notes') }}</title>

    {{-- Lucide Icons CDN --}}
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>

    {{-- App CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @auth
    {{-- ── Top header ────────────────────────────────────────── --}}
    <header>
        <nav>
            {{-- Brand --}}
            <div class="nav-brand">
                <a href="{{ route('dashboard') }}">
                    <i data-lucide="notebook-pen" class="brand-icon" style="width:18px;height:18px;"></i>
                    <strong>{{ config('app.name', 'Laravel Notes') }}</strong>
                </a>
            </div>

            {{-- Center links --}}
            <div class="nav-top-links">
                <a href="{{ route('dashboard') }}" class="nav-link">
                    <i data-lucide="layout-dashboard" style="width:15px;height:15px;"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
                <a href="{{ route('notebooks.index') }}" class="nav-link">
                    <i data-lucide="book-open" style="width:15px;height:15px;"></i>
                    <span class="nav-label">Notebooks</span>
                </a>
                <a href="{{ route('notes.index') }}" class="nav-link">
                    <i data-lucide="file-text" style="width:15px;height:15px;"></i>
                    <span class="nav-label">Notes</span>
                </a>
                <a href="{{ route('activity.index') }}" class="nav-link">
                    <i data-lucide="activity" style="width:15px;height:15px;"></i>
                    <span class="nav-label">Activity</span>
                </a>
                <a href="{{ route('trash.index') }}" class="nav-link">
                    <i data-lucide="trash-2" style="width:15px;height:15px;"></i>
                    <span class="nav-label">Trash</span>
                </a>
            </div>

            {{-- Right side --}}
            <div class="nav-right">
                <span class="nav-user">
                    <i data-lucide="circle-user" style="width:15px;height:15px;"></i>
                    {{ auth()->user()->name }}
                </span>
                <a href="{{ route('profile.edit') }}"
                   class="nav-icon-btn nav-profile-btn"
                   data-tooltip="Profile settings">
                    <i data-lucide="settings" style="width:16px;height:16px;"></i>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="logout-form">
                    @csrf
                    <button type="submit" class="btn-logout" data-tooltip="Sign out">
                        <i data-lucide="log-out" style="width:15px;height:15px;"></i>
                    </button>
                </form>
                {{-- Hamburger: only visible on mobile --}}
                <!--button class="nav-hamburger" aria-label="Toggle menu">
                    <span class="nav-ham-icon">
                        <i data-lucide="menu" style="width:20px;height:20px;"></i>
                    </span>
                </button-->
            </div>
        </nav>
    </header>

    {{-- ── Mobile bottom nav ─────────────────────────────────── --}}
    <nav class="mobile-nav" aria-label="Mobile navigation">
        <a href="{{ route('dashboard') }}" class="mobile-nav-link">
            <i data-lucide="layout-dashboard" style="width:22px;height:22px;"></i>
            <span class="mn-label">Dashboard</span>
        </a>
        <a href="{{ route('notebooks.index') }}" class="mobile-nav-link">
            <i data-lucide="book-open" style="width:22px;height:22px;"></i>
            <span class="mn-label">Notebooks</span>
        </a>
        <a href="{{ route('notes.index') }}" class="mobile-nav-link">
            <i data-lucide="file-text" style="width:22px;height:22px;"></i>
            <span class="mn-label">Notes</span>
        </a>
        <a href="{{ route('activity.index') }}" class="mobile-nav-link">
            <i data-lucide="activity" style="width:22px;height:22px;"></i>
            <span class="mn-label">Activity</span>
        </a>
        <a href="{{ route('trash.index') }}" class="mobile-nav-link">
            <i data-lucide="trash-2" style="width:22px;height:22px;"></i>
            <span class="mn-label">Trash</span>
        </a>
    </nav>
    @endauth

    <main>
        {{-- Flash: success --}}
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                <i data-lucide="check-circle-2" style="width:17px;height:17px;"></i>
                <div class="alert-body">{{ session('success') }}</div>
                <button class="alert-close" aria-label="Dismiss">
                    <i data-lucide="x" style="width:15px;height:15px;"></i>
                </button>
            </div>
        @endif

        {{-- Flash: error --}}
        @if (session('error'))
            <div class="alert alert-error" role="alert">
                <i data-lucide="alert-circle" style="width:17px;height:17px;"></i>
                <div class="alert-body">{{ session('error') }}</div>
                <button class="alert-close" aria-label="Dismiss">
                    <i data-lucide="x" style="width:15px;height:15px;"></i>
                </button>
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="alert alert-error" role="alert">
                <i data-lucide="alert-circle" style="width:17px;height:17px;"></i>
                <div class="alert-body">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="alert-close" aria-label="Dismiss">
                    <i data-lucide="x" style="width:15px;height:15px;"></i>
                </button>
            </div>
        @endif

        @yield('content')
    </main>

    {{-- App JS --}}
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>