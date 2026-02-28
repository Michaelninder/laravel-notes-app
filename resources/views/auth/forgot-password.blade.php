<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password — {{ config('app.name') }}</title>
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
                "Write it down. The brain is a processor, not a hard drive."
            </blockquote>
            <cite>Unknown</cite>
        </div>

        <div class="auth-panel-dots">
            <span></span>
            <span></span>
            <span class="active"></span>
        </div>
    </div>

    {{-- ── Right form ──────────────────────────────────────────── --}}
    <div class="auth-form-side">
        <div class="auth-card">

            <div class="auth-card-header">
                <div style="display:flex;align-items:center;gap:.65rem;margin-bottom:.75rem;">
                    <div style="width:42px;height:42px;border-radius:10px;background:var(--accent-light);color:var(--accent);display:flex;align-items:center;justify-content:center;">
                        <i data-lucide="key-round" style="width:20px;height:20px;"></i>
                    </div>
                </div>
                <h1>Forgot your password?</h1>
                <p>No problem — enter your email and we'll send you a reset link.</p>
            </div>

            @if (session('status'))
                <div class="auth-status">
                    <i data-lucide="check-circle-2" style="width:16px;height:16px;"></i>
                    {{ session('status') }}
                </div>
            @endif

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

            <form method="POST" action="{{ route('password.email') }}" class="auth-form">
                @csrf

                <div class="form-group" style="margin-bottom:1.5rem;">
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

                <button type="submit" class="btn btn-primary auth-submit">
                    <i data-lucide="send" style="width:15px;height:15px;"></i>
                    Send reset link
                </button>
            </form>

            <p class="auth-card-footer">
                <a href="{{ route('login') }}" style="display:inline-flex;align-items:center;gap:.3rem;">
                    <i data-lucide="arrow-left" style="width:13px;height:13px;"></i>
                    Back to sign in
                </a>
            </p>

        </div>
    </div>

</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>