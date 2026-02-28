<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel Notes') }} — Your thoughts, organised.</title>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="landing">

{{-- ── Nav ─────────────────────────────────────────────────── --}}
<header class="landing-nav">
    <div class="landing-nav-inner">
        <a href="/" class="landing-brand">
            <i data-lucide="notebook-pen" style="width:18px;height:18px;"></i>
            <strong>{{ config('app.name', 'Laravel Notes') }}</strong>
        </a>
        <div class="landing-nav-links">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">
                    <i data-lucide="layout-dashboard" style="width:14px;height:14px;"></i>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">Sign in</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                    Get started
                    <i data-lucide="arrow-right" style="width:13px;height:13px;"></i>
                </a>
            @endauth
        </div>
    </div>
</header>

<div class="landing-main">

    {{-- ── Hero ──────────────────────────────────────────────── --}}
    <section class="hero">
        <div class="hero-content">
            <div class="hero-kicker">
                <i data-lucide="sparkles" style="width:12px;height:12px;"></i>
                Simple · Fast · Yours
            </div>
            <h1 class="hero-title">
                Your thoughts,<br>
                <em>beautifully</em> organised.
            </h1>
            <p class="hero-sub">
                A quiet place to write, collect, and revisit your notes.
                Organised into notebooks. Always within reach.
            </p>
            <div class="hero-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        <i data-lucide="layout-dashboard" style="width:15px;height:15px;"></i>
                        Go to Dashboard
                    </a>
                @else
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        <i data-lucide="pen-line" style="width:15px;height:15px;"></i>
                        Start writing — free
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-ghost">Sign in</a>
                @endauth
            </div>
            <p class="hero-note">
                <i data-lucide="lock" style="width:12px;height:12px;"></i>
                No ads. No tracking. Just your notes.
            </p>
        </div>

        <div class="hero-visual">
            <div class="hero-visual-deco"></div>
            <div class="hero-visual-deco-2"></div>
            <div class="hero-mockup">
                {{-- fake window chrome --}}
                <div class="hm-topbar">
                    <span class="hm-dot hm-dot-r"></span>
                    <span class="hm-dot hm-dot-y"></span>
                    <span class="hm-dot hm-dot-g"></span>
                    <div class="hm-title-bar"></div>
                </div>
                <div class="hm-body">
                    {{-- notebooks list --}}
                    <div class="hm-notebook-row">
                        <div class="hm-nb-icon">
                            <i data-lucide="briefcase" style="width:13px;height:13px;"></i>
                        </div>
                        <span class="hm-nb-name">Work</span>
                        <span class="hm-nb-count">12 notes</span>
                    </div>
                    <div class="hm-notebook-row">
                        <div class="hm-nb-icon">
                            <i data-lucide="heart" style="width:13px;height:13px;"></i>
                        </div>
                        <span class="hm-nb-name">Personal</span>
                        <span class="hm-nb-count">7 notes</span>
                    </div>
                    <div class="hm-notebook-row">
                        <div class="hm-nb-icon">
                            <i data-lucide="lightbulb" style="width:13px;height:13px;"></i>
                        </div>
                        <span class="hm-nb-name">Ideas</span>
                        <span class="hm-nb-count">3 notes</span>
                    </div>

                    <div class="hm-divider"></div>

                    {{-- note preview --}}
                    <div class="hm-note-title">Meeting notes – Q1 review</div>
                    <div class="hm-note-line"></div>
                    <div class="hm-note-line"></div>
                    <div class="hm-note-line short"></div>
                    <div class="hm-divider"></div>
                    <div class="hm-note-line shorter"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Features ───────────────────────────────────────────── --}}
    <section class="features">
        <div class="features-inner">
            <p class="features-eyebrow">Everything you need</p>
            <h2 class="features-title">Built for how you actually think</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="book-open" style="width:18px;height:18px;"></i>
                    </div>
                    <h3>Notebooks</h3>
                    <p>Group related notes into labelled notebooks, each with its own icon and identity.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="zap" style="width:18px;height:18px;"></i>
                    </div>
                    <h3>Quick capture</h3>
                    <p>Write a note in seconds. No friction. No formatting required — just words.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="activity" style="width:18px;height:18px;"></i>
                    </div>
                    <h3>Activity log</h3>
                    <p>A full record of every change. See exactly what you created, edited, or deleted.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i data-lucide="trash-2" style="width:18px;height:18px;"></i>
                    </div>
                    <h3>Safe deletes</h3>
                    <p>Nothing is gone forever. Deleted notes stay in trash for 30 days before removal.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA ─────────────────────────────────────────────────── --}}
    <div class="landing-cta">
        <h2>Ready to start writing?</h2>
        <p>Create your free account in seconds. No credit card needed.</p>
        <div class="hero-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    <i data-lucide="layout-dashboard" style="width:15px;height:15px;"></i>
                    Go to Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-primary">
                    <i data-lucide="pen-line" style="width:15px;height:15px;"></i>
                    Create free account
                </a>
                <a href="{{ route('login') }}" class="btn btn-ghost">Sign in</a>
            @endauth
        </div>
    </div>

    {{-- ── Footer ──────────────────────────────────────────────── --}}
    <footer class="landing-footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. Made with care.
    </footer>

</div>{{-- /landing-main --}}

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>