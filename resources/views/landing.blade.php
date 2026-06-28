<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vandeesa</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@400;500;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #7C5CDB;
            --primary-light: #9B7DEC;
            --primary-dark: #5B3AA8;
            --secondary: #4F46E5;
            --accent: #F472B6;
            --bg-color: #FAFAFF;
            --text-main: #6e1a9e;
            --text-light: #6B7280;
            --white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-main);
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* ----- Navbar ----- */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 8%;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(124, 92, 219, 0.1);
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .navbar.scrolled {
            padding: 15px 8%;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .nav-logo {
            height: 40px;
            width: auto;
        }

        .nav-title {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: -0.5px;
        }

        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }

        .nav-item {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 15px;
            transition: color 0.3s ease;
            position: relative;
        }

        .nav-item::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary);
            transition: width 0.3s ease;
        }

        .nav-item:hover {
            color: var(--primary);
        }

        .nav-item:hover::after {
            width: 100%;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: var(--white);
            padding: 10px 24px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(124, 92, 219, 0.3);
            border: 2px solid transparent;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(124, 92, 219, 0.4);
            background: transparent;
            color: var(--primary);
            border-color: var(--primary);
        }

        /* Mobile Menu */
        .mobile-toggle {
            display: none;
            cursor: pointer;
            font-size: 24px;
            color: var(--primary);
        }

        /* ----- Hero Section ----- */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 120px 8% 60px;
            position: relative;
            overflow: hidden;
        }

        /* Abstract Background Elements */
        .hero-bg-1 {
            position: absolute;
            top: -10%;
            right: -5%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(124,92,219,0.15) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            z-index: -1;
            animation: pulse 8s infinite alternate;
        }

        .hero-bg-2 {
            position: absolute;
            bottom: 10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(244,114,182,0.1) 0%, rgba(255,255,255,0) 70%);
            border-radius: 50%;
            z-index: -1;
            animation: pulse 6s infinite alternate-reverse;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.8; }
            100% { transform: scale(1.2); opacity: 1; }
        }

        .hero-content {
            flex: 1;
            padding-right: 50px;
            animation: slideUp 1s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-badge {
            display: inline-block;
            padding: 8px 16px;
            background: rgba(124, 92, 219, 0.1);
            color: var(--primary);
            border-radius: 30px;
            font-weight: 700;
            font-size: 13px;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .hero-title {
            font-family: 'Outfit', sans-serif;
            font-size: 64px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 24px;
            color: var(--text-main);
        }

        .hero-title span {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 18px;
            color: var(--text-light);
            line-height: 1.6;
            margin-bottom: 40px;
            max-width: 540px;
        }

        .hero-actions {
            display: flex;
            gap: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: var(--white);
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(124, 92, 219, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(124, 92, 219, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 16px;
            border: 2px solid var(--primary-light);
            transition: all 0.3s ease;
        }

        .btn-outline:hover {
            border-color: var(--primary);
            background: rgba(124, 92, 219, 0.05);
        }

        .hero-image {
            flex: 1;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            animation: fadeIn 1.5s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .img-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            position: relative;
        }

        .img-card {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            transition: transform 0.4s ease;
            position: relative;
        }

        .img-card:hover {
            transform: translateY(-10px) scale(1.02);
            z-index: 10;
        }

        .img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .img-1 { height: 320px; transform: translateY(40px); }
        .img-2 { height: 260px; }
        .img-3 { height: 240px; transform: translateY(-20px); grid-column: span 2; }

        /* Floating Badge */
        .floating-badge {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            padding: 16px 24px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(124, 92, 219, 0.15);
            display: flex;
            align-items: center;
            gap: 15px;
            bottom: 30px;
            left: -40px;
            animation: float 4s ease-in-out infinite;
            border: 1px solid rgba(255,255,255,0.5);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .badge-icon {
            font-size: 28px;
            background: linear-gradient(135deg, #FDE68A, #F59E0B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .badge-text h4 {
            font-size: 18px;
            color: var(--text-main);
            font-weight: 800;
        }

        .badge-text p {
            font-size: 12px;
            color: var(--text-light);
            font-weight: 600;
        }

        /* ----- About Section ----- */
        .section {
            padding: 100px 8%;
        }

        .about-section {
            background: var(--white);
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .section-tag {
            color: var(--primary);
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
            display: block;
        }

        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 40px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 20px;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
        }

        .about-text p {
            font-size: 17px;
            color: var(--text-light);
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .feature-list {
            list-style: none;
            margin-top: 30px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 600;
            color: var(--text-main);
        }

        .feature-icon {
            width: 32px;
            height: 32px;
            background: rgba(124, 92, 219, 0.1);
            color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .about-image {
            position: relative;
        }

        .about-image img {
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
        }

        .about-shape {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid var(--primary);
            border-radius: 24px;
            top: 20px;
            left: -20px;
            z-index: -1;
        }

        /* ----- Product Section ----- */
        .product-section {
            background: linear-gradient(180deg, var(--bg-color) 0%, #F5F3FF 100%);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
        }

        .product-card {
            background: var(--white);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.5);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(124, 92, 219, 0.15);
        }

        .product-img-wrap {
            width: 100%;
            height: 240px;
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .product-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-img-wrap img {
            transform: scale(1.1);
        }

        .product-category {
            font-size: 12px;
            color: var(--primary);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .product-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-main);
            margin-bottom: 10px;
        }

        /* ----- Footer ----- */
        .footer {
            background: #111827;
            color: #9CA3AF;
            padding: 80px 8% 30px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-brand h2 {
            color: var(--white);
            font-family: 'Outfit', sans-serif;
            font-size: 28px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .footer-brand p {
            line-height: 1.8;
            max-width: 350px;
        }

        .footer-title {
            color: var(--white);
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #9CA3AF;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: var(--primary-light);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 30px;
            text-align: center;
            font-size: 14px;
        }

        /* ----- Responsive ----- */
        @media (max-width: 991px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding-top: 140px;
            }
            .hero-content {
                padding-right: 0;
                margin-bottom: 60px;
            }
            .hero-desc {
                margin: 0 auto 40px;
            }
            .hero-actions {
                justify-content: center;
            }
            .about-grid {
                grid-template-columns: 1fr;
            }
            .about-image {
                grid-row: 1;
            }
            .floating-badge {
                left: 20px;
            }
        }

        @media (max-width: 768px) {
            .nav-links, .btn-login {
                display: none;
            }
            .mobile-toggle {
                display: block;
            }
            .hero-title {
                font-size: 46px;
            }
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }
            .img-grid {
                gap: 10px;
            }
            .img-1 { height: 220px; transform: translateY(20px); }
            .img-2 { height: 180px; }
            .img-3 { height: 160px; transform: translateY(-10px); }
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar" id="navbar">
        <a href="#" class="nav-brand">
            @if(file_exists(public_path('images/items/LOGO VANDEESA.png')))
                <img src="{{ asset('images/items/LOGO VANDEESA.png') }}" alt="Vandeesa Logo" class="nav-logo">
            @else
                <div class="nav-logo" style="background:var(--primary); width:40px; height:40px; border-radius:10px; display:flex; align-items:center; justify-content:center; color:white; font-weight:bold; font-size:24px;">V</div>
            @endif
        </a>

        <div class="nav-links" id="navLinks">
            <a href="#home" class="nav-item">Beranda</a>
            <a href="#about" class="nav-item">Profile</a>
            <a href="#products" class="nav-item">Produk</a>
        </div>

        <a href="{{ route('login') }}" class="btn-login">Masuk Aplikasi</a>

        <div class="mobile-toggle" onclick="toggleMenu()">☰</div>
    </nav>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-bg-1"></div>
        <div class="hero-bg-2"></div>

        <div class="hero-content">
            <div class="hero-badge">✨ Kualitas Terbaik</div>
            <h1 class="hero-title">Modesty Meets Modernity,<br><span></span></h1>
            <p class="hero-desc">Vandeesa hadir dengan dedikasi tinggi memberikan pilihan fashion premium dan solusi perawatan kulit terpercaya. Temukan kepercayaan diri baru Anda bersama koleksi eksklusif kami.</p>

            <div class="hero-actions">
                <a href="#products" class="btn-primary">
                    Eksplor Produk
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                </a>
                <a href="{{ route('login') }}" class="btn-outline">Sistem Login</a>
            </div>
        </div>

        <div class="hero-image">
            <div class="img-grid">
                <div class="img-card img-1">
                    @if(file_exists(public_path('images/items/1781706618_SCR003.jpg')))
                        <img src="{{ asset('images/items/1781706618_SCR003.jpg') }}" alt="Skincare Product">
                    @else
                        <div style="background:#E9D5FF; width:100%; height:100%;"></div>
                    @endif
                </div>
                <div class="img-card img-2">
                    @if(file_exists(public_path('images/items/1781706760_SCR007.jpg')))
                        <img src="{{ asset('images/items/1781706760_SCR007.jpg') }}" alt="Beauty Product">
                    @else
                        <div style="background:#D8B4FE; width:100%; height:100%;"></div>
                    @endif
                </div>
                <div class="img-card img-3">
                    @if(file_exists(public_path('images/items/1781707062_SCR014.jpg')))
                        <img src="{{ asset('images/items/1781707062_SCR014.jpg') }}" alt="Fashion Collection">
                    @else
                        <div style="background:#C084FC; width:100%; height:100%;"></div>
                    @endif
                </div>
            </div>

            <div class="floating-badge">
                <div class="badge-icon">⭐</div>
                <div class="badge-text">
                    <h4>Premium Quality</h4>
                    <p>Terjamin 100% Original</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="section about-section" id="about">
        <div class="about-grid">
            <div class="about-image">
                <div class="about-shape"></div>
                @if(file_exists(public_path('images/items/1781707338_SCR020.jpg')))
                    <img src="{{ asset('images/items/1781707338_SCR020.jpg') }}" alt="Tentang Vandeesa">
                @else
                    <div style="background:var(--primary-light); height:500px; border-radius:24px;"></div>
                @endif
            </div>

            <div class="about-text">
                <span class="section-tag">Tentang Kami</span>
                <h2 class="section-title">Harmoni Sempurna Antara Fashion & Skincare</h2>
                <p>Vandeesa berawal dari visi untuk menyatukan dua elemen penting dalam penampilan: gaya berbusana yang memukau dan kulit yang sehat terawat. Kami memahami bahwa kecantikan sejati terpancar ketika Anda merasa nyaman dengan apa yang Anda kenakan dan bagaimana kulit Anda bernapas.</p>
                <p>Seluruh produk kami telah melewati proses kurasi dan kontrol kualitas yang ketat untuk memastikan Anda hanya mendapatkan yang terbaik.</p>

                <ul class="feature-list">
                    <li class="feature-item">
                        <div class="feature-icon">✓</div>
                        Bahan baku berkualitas & tersertifikasi
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">✓</div>
                        Desain eksklusif dan up-to-date
                    </li>
                    <li class="feature-item">
                        <div class="feature-icon">✓</div>
                        Pelayanan pelanggan yang responsif
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Products Section -->
    <section class="section product-section" id="products">
        <div class="section-header">
            <span class="section-tag">Koleksi Kami</span>
            <h2 class="section-title">Pilihan Terbaik Untuk Anda</h2>
            <p style="color:var(--text-light); font-size:16px;">Jelajahi berbagai pilihan produk unggulan kami yang diformulasikan khusus untuk memenuhi standar ekspektasi tertinggi Anda.</p>
        </div>

        <div class="product-grid">
            <!-- Product 1 -->
            <div class="product-card">
                <div class="product-img-wrap">
                    @if(file_exists(public_path('images/items/1781706651_SCR004.jpg')))
                        <img src="{{ asset('images/items/1781706651_SCR004.jpg') }}" alt="Produk 1">
                    @else
                        <div style="background:#E9D5FF; width:100%; height:100%;"></div>
                    @endif
                </div>
                <div class="product-category"></div>
                <h3 class="product-title"></h3>
            </div>

            <!-- Product 2 -->
            <div class="product-card">
                <div class="product-img-wrap">
                    @if(file_exists(public_path('images/items/1781706856_SCR009.jpg')))
                        <img src="{{ asset('images/items/1781706856_SCR009.jpg') }}" alt="Produk 2">
                    @else
                        <div style="background:#D8B4FE; width:100%; height:100%;"></div>
                    @endif
                </div>
                <div class="product-category"></div>
                <h3 class="product-title"></h3>
            </div>

            <!-- Product 3 -->
            <div class="product-card">
                <div class="product-img-wrap">
                    @if(file_exists(public_path('images/items/1781707296_SCR019.jpg')))
                        <img src="{{ asset('images/items/1781707296_SCR019.jpg') }}" alt="Produk 3">
                    @else
                        <div style="background:#C084FC; width:100%; height:100%;"></div>
                    @endif
                </div>
                <div class="product-category"></div>
                <h3 class="product-title"></h3>
            </div>

            <!-- Product 4 -->
            <div class="product-card">
                <div class="product-img-wrap">
                    @if(file_exists(public_path('images/items/1781707630_SCR024.jpg')))
                        <img src="{{ asset('images/items/1781707630_SCR024.jpg') }}" alt="Produk 4">
                    @else
                        <div style="background:#A855F7; width:100%; height:100%;"></div>
                    @endif
                </div>
                <div class="product-category"></div>
                <h3 class="product-title"></h3>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-grid">
            <div class="footer-brand">
                <h2>
                    @if(file_exists(public_path('images/items/LOGO VANDEESA.png')))
                        <img src="{{ asset('images/items/LOGO VANDEESA.png') }}" alt="Vandeesa" style="height:35px; border-radius:6px;">
                    @endif
                </h2>
                <p>Menghadirkan harmoni sempurna antara gaya dan perawatan diri. Solusi terpercaya untuk menunjang penampilan dan kecantikan paripurna Anda setiap hari.</p>
            </div>

            <div>
                <h4 class="footer-title">Tautan Cepat</h4>
                <ul class="footer-links">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#about">Tentang Kami</a></li>
                    <li><a href="#products">Katalog Produk</a></li>
                </ul>
            </div>

            <div>
                <h4 class="footer-title">Kontak & Bantuan</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('login') }}">Login Sistem</a></li>
                    <li><a href="#">Layanan Pelanggan</a></li>
                    <li><a href="#">FAQ</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Vandeesa Official. Hak cipta dilindungi undang-undang.</p>
        </div>
    </footer>

    <script>
        // Navbar Scroll Effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Mobile Menu Toggle (Simplified)
        function toggleMenu() {
            const links = document.getElementById('navLinks');
            const loginBtn = document.querySelector('.btn-login');

            if (links.style.display === 'flex') {
                links.style.display = 'none';
                loginBtn.style.display = 'none';
            } else {
                links.style.display = 'flex';
                links.style.flexDirection = 'column';
                links.style.position = 'absolute';
                links.style.top = '100%';
                links.style.left = '0';
                links.style.width = '100%';
                links.style.background = '#fff';
                links.style.padding = '20px';
                links.style.boxShadow = '0 10px 20px rgba(0,0,0,0.1)';
                loginBtn.style.display = 'inline-block';
                loginBtn.style.margin = '20px auto 0';
            }
        }
    </script>
</body>
</html>
