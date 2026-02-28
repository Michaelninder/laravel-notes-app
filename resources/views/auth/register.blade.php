<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create account — {{ config('app.name') }}</title>
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
                "An idea not written down is an idea lost."
            </blockquote>
            <cite>Unknown</cite>
        </div>

        <div class="auth-panel-dots">
            <span></span>
            <span class="active"></span>
            <span></span>
        </div>
    </div>

    {{-- ── Right form ──────────────────────────────────────────── --}}
    <div class="auth-form-side">
        <div class="auth-card">

            <div class="auth-card-header">
                <h1>Create your account</h1>
                <p>Free forever. Start writing in seconds.</p>
            </div>

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

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <div class="form-group">
                    <label for="name">Full name</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i data-lucide="user" style="width:15px;height:15px;"></i>
                        </span>
                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Your name"
                               required
                               autofocus
                               autocomplete="name">
                    </div>
                </div>

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
                               placeholder="Min. 8 characters"
                               required
                               autocomplete="new-password">
                        <button type="button" class="pw-toggle" aria-label="Show password">
                            <i data-lucide="eye" style="width:16px;height:16px;"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom:1.5rem;">
                    <label for="password_confirmation">Confirm password</label>
                    <div class="input-wrap">
                        <span class="input-icon">
                            <i data-lucide="lock-keyhole" style="width:15px;height:15px;"></i>
                        </span>
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="••••••••"
                               required
                               autocomplete="new-password">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary auth-submit">
                    <i data-lucide="user-plus" style="width:15px;height:15px;"></i>
                    Create account
                </button>
            </form>

            <p class="auth-card-footer">
                Already have an account?
                <a href="{{ route('login') }}">Sign in</a>
            </p>

        </div>
    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>