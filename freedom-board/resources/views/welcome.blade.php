<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Freedom Board</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;600&family=Syne:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-brand">Freedom Board</div>
        <div class="navbar-links">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/board') }}" class="btn-nav">Go to Board</a>
                @else
                    <a href="{{ route('login') }}" class="btn-nav">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-nav btn-nav-primary">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="hero">
        <div class="hero-content">
            <div class="hero-badge">Open · Anonymous-friendly · Free</div>
            <h1 class="hero-title">Your Voice.<br>Unfiltered.</h1>
            <p class="hero-subtitle">
                Freedom Board is a space to speak freely, reply openly, and connect honestly —
                no algorithms, no noise, just conversation.
            </p>
            <div class="hero-actions">
                @auth
                    <a href="{{ url('/board') }}" class="btn-primary">Open the Board →</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary">Get Started →</a>
                    <a href="{{ route('login') }}" class="btn-secondary">Sign In</a>
                @endauth
            </div>
        </div>

        <div class="hero-visual" aria-hidden="true">
            <div class="mock-post">
                <span class="mock-user">alice_w</span>
                <p>Does anyone else feel like modern social media is just outrage machines at this point?</p>
                <div class="mock-meta">just now</div>
                <div class="mock-reply">
                    <span class="mock-user reply-user">↳ b3n_says</span>
                    <p>100%. That's why I'm here.</p>
                </div>
            </div>
            <div class="mock-post mock-post-2">
                <span class="mock-user">curious_cat</span>
                <p>What's everyone reading lately? Looking for recs 📚</p>
                <div class="mock-meta">3 min ago</div>
            </div>
        </div>
    </main>

    <!-- Features -->
    <section class="features">
        <div class="feature-card">
            <div class="feature-icon">✍️</div>
            <h3>Post Freely</h3>
            <p>Share thoughts, ideas, or questions with the board. No character limits, no promoted content.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">↩️</div>
            <h3>Reply & Discuss</h3>
            <p>Engage in threaded replies directly under posts. Real conversations, not likes.</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon">🔍</div>
            <h3>Search Topics</h3>
            <p>Find posts by content or author instantly with the built-in search.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="site-footer">
        <p>Freedom Board &copy; {{ date('Y') }}</p>
    </footer>

</body>
</html>