<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Laravel ✨</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #7C5CDB;
            --primary-dark: #6B46C1;
            --bg-light: #F5F3FF;
            --text-dark: #1F2937;
            --text-muted: #6B7280;
            --glass-bg: rgba(255, 255, 255, 0.6);
            --glass-border: rgba(255, 255, 255, 0.8);
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top left, var(--bg-light) 0%, #E0E7FF 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        /* Navbar */
        .navbar {
            display: flex;
            justify-content: flex-end;
            padding: 1.5rem 2rem;
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 100;
            background: rgba(245, 243, 255, 0.8);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(123, 92, 219, 0.1);
        }
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.6rem 1.5rem;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            gap: 0.4rem;
        }
        .btn-outline {
            color: var(--primary);
            background: var(--glass-bg);
            border: 2px solid var(--primary);
        }
        .btn-outline:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 4px 15px rgba(123, 92, 219, 0.3);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: 2px solid transparent;
        }
        .btn-primary:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 4px 15px rgba(123, 92, 219, 0.4);
        }
        .nav-links {
            display: flex;
            gap: 1rem;
        }
        /* Hero Section */
        .hero {
            margin-top: 8rem;
            text-align: center;
            padding: 2rem 2rem 4rem;
        }
        .hero-float {
            animation: float 6s ease-in-out infinite;
        }
        .hero h1 {
            font-size: clamp(3rem, 5vw, 5rem);
            font-weight: 800;
            margin: 0;
            background: linear-gradient(135deg, var(--primary), #D946EF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -1.5px;
            line-height: 1.2;
        }
        .hero p {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 1.5rem auto 2.5rem;
            line-height: 1.6;
        }
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            flex: 1;
            width: 100%;
        }
        /* Grid for Features */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 5rem;
        }
        /* Glass Card */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 1.5rem;
            padding: 2.5rem 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(123, 92, 219, 0.05);
            opacity: 0; /* for animation */
        }
        a.glass-card {
            display: block;
        }
        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(123, 92, 219, 0.15);
            border-color: rgba(123, 92, 219, 0.4);
        }
        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, white, var(--bg-light));
            width: 4rem;
            height: 4rem;
            border-radius: 1.2rem;
            box-shadow: 0 4px 10px rgba(123, 92, 219, 0.1);
            animation: float 4s ease-in-out infinite;
        }
        .glass-card h3 {
            margin: 0 0 1rem 0;
            font-size: 1.4rem;
            color: var(--text-dark);
            font-weight: 700;
        }
        .glass-card p {
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0;
            font-size: 0.95rem;
        }
        .glass-card p a {
            color: var(--primary);
            font-weight: 600;
            transition: color 0.3s ease;
        }
        .glass-card p a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
        /* Footer */
        footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem;
            border-top: 1px solid rgba(123, 92, 219, 0.1);
            background: rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
            flex-wrap: wrap;
            gap: 1rem;
        }
        .footer-links {
            display: flex;
            gap: 2rem;
        }
        .footer-links a {
            color: var(--text-muted);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .footer-links a:hover {
            color: var(--primary);
            transform: translateY(-2px);
        }
        .version-info {
            color: var(--primary-dark);
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(123, 92, 219, 0.1);
            padding: 0.6rem 1.2rem;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .version-info span {
            background: white;
            padding: 0.2rem 0.6rem;
            border-radius: 999px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        /* Animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        .delay-0 { animation-delay: 0.1s; }
        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.4s; }
        
        /* Mobile responsive */
        @media (max-width: 768px) {
            .navbar { padding: 1rem; justify-content: center; }
            .hero { margin-top: 6rem; }
            footer { flex-direction: column; text-align: center; justify-content: center; }
            .footer-links { flex-direction: column; gap: 1rem; align-items: center; }
        }
    </style>
</head>
<body>

    @if (Route::has('login'))
        <nav class="navbar">
            <div class="nav-links">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">🏠 Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline">👋 Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">✨ Register</a>
                    @endif
                @endauth
            </div>
        </nav>
    @endif

    <div class="hero hero-float">
        <h1>Laravel Vibes 🚀</h1>
        <p>A beautifully crafted landing page with modern Gen Z aesthetics. Enjoy smooth animations, rich glassmorphism, and seamless gradients.</p>
    </div>

    <div class="container">
        <div class="features-grid">
            
            <a href="https://laravel.com/docs" class="glass-card animate-fade-in delay-0">
                <div class="card-icon delay-0">📚</div>
                <h3>Documentation</h3>
                <p>Laravel has wonderful, thorough documentation covering every aspect of the framework. Whether you are new to the framework or have previous experience, we recommend reading all of the documentation from beginning to end.</p>
            </a>

            <a href="https://laracasts.com" class="glass-card animate-fade-in delay-1">
                <div class="card-icon delay-1">🎥</div>
                <h3>Laracasts</h3>
                <p>Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.</p>
            </a>

            <a href="https://laravel-news.com/" class="glass-card animate-fade-in delay-2">
                <div class="card-icon delay-2">📰</div>
                <h3>Laravel News</h3>
                <p>Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.</p>
            </a>

            <div class="glass-card animate-fade-in delay-3">
                <div class="card-icon delay-3">🌍</div>
                <h3>Vibrant Ecosystem</h3>
                <p>Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com">Forge</a>, <a href="https://vapor.laravel.com">Vapor</a>, <a href="https://nova.laravel.com">Nova</a>, and <a href="https://envoyer.io">Envoyer</a> help you take your projects to the next level. Pair them with powerful open source libraries like <a href="https://laravel.com/docs/billing">Cashier</a>, <a href="https://laravel.com/docs/dusk">Dusk</a>, <a href="https://laravel.com/docs/broadcasting">Echo</a>, <a href="https://laravel.com/docs/horizon">Horizon</a>, <a href="https://laravel.com/docs/sanctum">Sanctum</a>, <a href="https://laravel.com/docs/telescope">Telescope</a>, and more.</p>
            </div>

        </div>
    </div>

    <footer>
        <div class="footer-links">
            <a href="https://laravel.bigcartel.com">🛒 Shop</a>
            <a href="https://github.com/sponsors/taylorotwell">💖 Sponsor</a>
        </div>
        <div class="version-info">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} <span>PHP v{{ PHP_VERSION }}</span>
        </div>
    </footer>

</body>
</html>
