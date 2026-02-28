<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in — {{ config('app.name') }}</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="auth-page">

    {{-- ── Left panel ─────────────────────────────────────────── --}}
    <div class="auth-panel">
        <a href="/" class="auth-panel-brand">
            <i data-lucide="notebook-pen" style="width:20px;height:20px;"></i>
            {{ config('app.name', 'Laravel Notes') }}
        </a>

        <div class="auth-panel-copy">
            <blockquote>
                "The palest ink is better than the best memory."
            </blockquote>
            <cite>Chinese Proverb</cite>
        </div>

        <div class="auth-panel-dots">
            <span class="active"></span>
            <span></span>
            <span></span>
        </div>
    </div>

    {{-- ── Right form ──────────────────────────────────────────── --}}
    <div class="auth-form-side">
        <div class="auth-card">

            <div class="auth-card-header">
                <h1>Welcome back</h1>
                <p>Sign in to your account to continue.</p>
            </div>

            {{-- Status (e.g. password reset confirmation) --}}
            @if (session('status'))
                <div class="auth-status">
                    <i data-lucide="check-circle-2" style="width:16px;height:16px;"></i>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="alert alert-error" role="alert" style="margin-bottom:1.25rem;">
                    <i data-lucide="alert-circle" style="width:16px;height:16px;"></i>
                    <div class="alert-body">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="email">Email address</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i data-lucide="mail" style="width:15px;height:15px;"></i>
                        </span>
                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               placeholder="you@example.com"
                               required
                               autofocus
                               autocomplete="email">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i data-lucide="lock" style="width:15px;height:15px;"></i>
                        </span>
                        <input type="password"
                               id="password"
                               name="password"
                               placeholder="••••••••"
                               required
                               autocomplete="current-password">
                        <button type="button" class="pw-toggle" aria-label="Show password">
                            <i data-lucide="eye" style="width:16px;height:16px;"></i>
                        </button>
                    </div>
                </div>

                <div class="auth-checkbox-row">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="auth-forgot">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary auth-submit">
                    <i data-lucide="log-in" style="width:15px;height:15px;"></i>
                    Sign in
                </button>
            </form>

            @if (Route::has('register'))
                <p class="auth-card-footer">
                    Don't have an account?
                    <a href="{{ route('register') }}">Create one free</a>
                </p>
            @endif

        </div>
    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>