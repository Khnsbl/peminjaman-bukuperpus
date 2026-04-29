<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PustakaKu - Sistem Peminjaman Buku</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green-dark: #1A2E27;
            --green-main: #2C4A3E;
            --green-mid: #3D6357;
            --green-soft: #5B8C7A;
            --green-pale: #E8F0ED;
            --green-light: #C5D5D0;
            --cream: #FAFAF7;
            --border: #E8E5DC;
            --text-muted: #6B7280;
            --text-subtle: #9CA3AF;
            --white: #FFFFFF;
        }

        html { scroll-behavior: smooth; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--green-dark);
            overflow-x: hidden;
        }

        /* ─── NAVBAR ─── */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 3rem;
            background: var(--cream);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 36px;
            height: 36px;
            background: var(--green-main);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--green-dark);
            letter-spacing: -0.3px;
        }

        .logo-text span { color: var(--green-soft); }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            list-style: none;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-size: 14px;
            font-weight: 400;
            transition: color 0.2s;
        }

        .nav-links a:hover { color: var(--green-main); }

        .nav-btns {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-login {
            padding: 8px 20px;
            border: 1.5px solid var(--green-main);
            background: transparent;
            color: var(--green-main);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-login:hover { background: var(--green-main); color: var(--white); }

        .btn-register {
            padding: 8px 20px;
            border: 1.5px solid var(--green-main);
            background: var(--green-main);
            color: var(--white);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-register:hover { background: var(--green-dark); border-color: var(--green-dark); }

        /* ─── HERO ─── */
        .hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: calc(100vh - 65px);
            align-items: stretch;
        }

        .hero-left {
            padding: 4rem 3rem 4rem 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            animation: fadeInLeft 0.8s ease forwards;
        }

        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        .badge {
            display: inline-block;
            background: var(--green-pale);
            color: var(--green-main);
            font-size: 12px;
            font-weight: 500;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 1.5rem;
            letter-spacing: 0.5px;
            width: fit-content;
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: 52px;
            font-weight: 900;
            color: var(--green-dark);
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }

        .hero-title .accent {
            color: var(--green-soft);
            font-style: italic;
        }

        .hero-desc {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            max-width: 420px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            align-items: center;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            padding: 14px 28px;
            background: var(--green-main);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover { background: var(--green-dark); transform: translateY(-2px); }

        .btn-outline {
            padding: 14px 28px;
            background: transparent;
            color: var(--green-main);
            border: 1.5px solid var(--green-light);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline:hover { border-color: var(--green-main); }

        /* Stats */
        .stats {
            display: flex;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .stat { display: flex; flex-direction: column; gap: 2px; }

        .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--green-dark);
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-subtle);
            font-weight: 400;
        }

        .stat-divider {
            width: 1px;
            height: 40px;
            background: var(--border);
            align-self: center;
        }

        /* ─── HERO RIGHT ─── */
        .hero-right {
            background: var(--green-main);
            min-height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            animation: fadeInRight 0.8s ease forwards;
        }

        .deco-circle {
            position: absolute;
            border-radius: 50%;
            opacity: 0.05;
            background: var(--white);
            pointer-events: none;
        }

        .deco-1 { width: 200px; height: 200px; bottom: -60px; right: -60px; }
        .deco-2 { width: 120px; height: 120px; top: 40px; right: 20px; }
        .deco-3 { width: 80px; height: 80px; top: 50%; left: -20px; }

        .books-display {
            display: flex;
            flex-direction: column;
            gap: 14px;
            padding: 3rem;
            width: 100%;
            max-width: 380px;
        }

        .display-label {
            font-size: 11px;
            color: rgba(255,255,255,0.4);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .book-card {
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.12);
            border-radius: 12px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .book-card:hover {
            background: rgba(255,255,255,0.13);
            transform: translateX(4px);
        }

        .book-cover {
            width: 42px;
            height: 56px;
            border-radius: 5px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .book-info { flex: 1; min-width: 0; }

        .book-title {
            font-family: 'Playfair Display', serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--white);
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-author {
            font-size: 12px;
            color: rgba(255,255,255,0.5);
            margin-bottom: 7px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-status {
            display: inline-block;
            font-size: 11px;
            font-weight: 500;
            padding: 3px 10px;
            border-radius: 20px;
        }

        .status-available { background: rgba(91,140,122,0.3); color: #9FCFC1; }
        .status-borrowed  { background: rgba(239,159,39,0.2);  color: #EF9F27; }
        .status-returned  { background: rgba(91,140,122,0.2);  color: #7BB5A5; }

        .book-due {
            font-size: 11px;
            color: rgba(255,255,255,0.35);
            white-space: nowrap;
            text-align: right;
            line-height: 1.5;
        }

        /* ─── FEATURES ─── */
        .features {
            padding: 5rem 4rem;
            background: var(--white);
        }

        .section-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--green-soft);
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 1rem;
            text-align: center;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 38px;
            font-weight: 700;
            color: var(--green-dark);
            text-align: center;
            margin-bottom: 3.5rem;
            letter-spacing: -0.5px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 900px;
            margin: 0 auto;
        }

        .feature-item {
            text-align: center;
            padding: 2rem 1.5rem;
            border-radius: 14px;
            border: 1px solid #F0EDE6;
            transition: all 0.3s;
        }

        .feature-item:hover {
            border-color: var(--green-light);
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(44, 74, 62, 0.08);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--green-pale);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.2rem;
        }

        .feature-name {
            font-family: 'Playfair Display', serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 0.6rem;
        }

        .feature-desc {
            font-size: 13px;
            color: var(--text-subtle);
            line-height: 1.6;
        }

        /* ─── HOW IT WORKS ─── */
        .how-it-works {
            padding: 5rem 4rem;
            background: var(--cream);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            max-width: 960px;
            margin: 0 auto;
        }

        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 1.5rem 1rem;
        }

        .step-num {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--green-main);
            color: var(--white);
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            flex-shrink: 0;
        }

        .step-title {
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 0.5rem;
        }

        .step-desc {
            font-size: 13px;
            color: var(--text-subtle);
            line-height: 1.6;
        }

        /* ─── CTA BANNER ─── */
        .cta-section {
            background: var(--green-main);
            padding: 5rem 4rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: -80px;
            left: -80px;
        }

        .cta-section::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -60px;
            right: -40px;
        }

        .cta-title {
            font-family: 'Playfair Display', serif;
            font-size: 40px;
            font-weight: 900;
            color: var(--white);
            margin-bottom: 1rem;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }

        .cta-desc {
            font-size: 16px;
            color: rgba(255,255,255,0.65);
            margin-bottom: 2.5rem;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
            position: relative;
            z-index: 1;
        }

        .cta-btns {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            position: relative;
            z-index: 1;
        }

        .btn-cta-primary {
            padding: 14px 32px;
            background: var(--white);
            color: var(--green-main);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-cta-primary:hover { background: var(--cream); transform: translateY(-2px); }

        .btn-cta-outline {
            padding: 14px 32px;
            background: transparent;
            color: var(--white);
            border: 1.5px solid rgba(255,255,255,0.35);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-cta-outline:hover { border-color: rgba(255,255,255,0.7); }

        /* ─── FOOTER ─── */
        footer {
            background: var(--green-dark);
            padding: 2rem 4rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .footer-logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            color: var(--white);
        }

        .footer-logo-text span { color: var(--green-soft); }

        .footer-copy {
            font-size: 13px;
            color: rgba(255,255,255,0.35);
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 900px) {
            nav { padding: 1rem 1.5rem; }
            .nav-links { display: none; }

            .hero { grid-template-columns: 1fr; }
            .hero-left { padding: 3rem 2rem; }
            .hero-title { font-size: 38px; }
            .hero-right { min-height: 420px; }

            .features { padding: 3rem 2rem; }
            .features-grid { grid-template-columns: 1fr; gap: 1.2rem; }

            .how-it-works { padding: 3rem 2rem; }
            .steps-grid { grid-template-columns: 1fr 1fr; }

            .cta-section { padding: 3rem 2rem; }
            .cta-title { font-size: 30px; }

            footer { padding: 1.5rem 2rem; }
        }

        @media (max-width: 500px) {
            .steps-grid { grid-template-columns: 1fr; }
            .hero-title { font-size: 32px; }
            .stats { gap: 1.2rem; }
            .stat-divider { display: none; }
        }
    </style>
</head>
<body>

{{-- ─── NAVBAR ─── --}}
<nav>
    <a href="{{ url('/') }}" class="logo">
        <div class="logo-icon">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="3" y="2" width="5" height="16" rx="1" fill="white" opacity="0.9"/>
                <rect x="9" y="2" width="5" height="16" rx="1" fill="white" opacity="0.7"/>
                <rect x="15" y="4" width="3" height="12" rx="1" fill="white" opacity="0.5"/>
            </svg>
        </div>
        <span class="logo-text">Pustaka<span>Ku</span></span>
    </a>

    <ul class="nav-links">
        <li><a href="#">Katalog Buku</a></li>
        <li><a href="#">Peminjaman</a></li>
        <li><a href="#">Tentang Kami</a></li>
        <li><a href="#">Kontak</a></li>
    </ul>

    <div class="nav-btns">
        @if (Route::has('login'))
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-login">Dashboard Admin</a>
                @else
                    <a href="{{ route('user.dashboard') }}" class="btn-login">Dashboard Saya</a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-register">Daftar</a>
                @endif
            @endauth
        @endif
    </div>
</nav>

{{-- ─── HERO ─── --}}
<section class="hero">
    <div class="hero-left">
        <div class="badge">Sistem Perpustakaan Digital</div>
        <h1 class="hero-title">
            Pinjam Buku,<br>
            <span class="accent">Kapan Saja</span><br>
            &amp; Di Mana Saja
        </h1>
        <p class="hero-desc">
            Nikmati kemudahan meminjam buku dari koleksi perpustakaan kami yang lengkap.
            Daftar sekarang dan mulai perjalanan literasi Anda hari ini.
        </p>
        <div class="hero-actions">
            @auth
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1L14 5V11L8 15L2 11V5L8 1Z" stroke="white" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        Kelola Perpustakaan
                    </a>
                @else
                    <a href="{{ route('user.buku.index') }}" class="btn-primary">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1L14 5V11L8 15L2 11V5L8 1Z" stroke="white" stroke-width="1.5" stroke-linejoin="round"/></svg>
                        Mulai Meminjam
                    </a>
                @endif
            @else
                <a href="{{ route('register') }}" class="btn-primary">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M8 1L14 5V11L8 15L2 11V5L8 1Z" stroke="white" stroke-width="1.5" stroke-linejoin="round"/></svg>
                    Daftar Sekarang
                </a>
            @endauth
            <a href="{{ route('login') }}" class="btn-outline">Masuk</a>
        </div>
        <div class="stats">
            <div class="stat">
                <span class="stat-num">5.200+</span>
                <span class="stat-label">Koleksi Buku</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat">
                <span class="stat-num">1.800+</span>
                <span class="stat-label">Anggota Aktif</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat">
                <span class="stat-num">98%</span>
                <span class="stat-label">Kepuasan</span>
            </div>
        </div>
    </div>

    <div class="hero-right">
        <div class="deco-circle deco-1"></div>
        <div class="deco-circle deco-2"></div>
        <div class="deco-circle deco-3"></div>
        <div class="books-display">
            <p class="display-label">Peminjaman Aktif</p>

            <div class="book-card">
                <div class="book-cover" style="background: #8B5CF6;">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><rect x="4" y="2" width="10" height="18" rx="2" fill="white" opacity="0.9"/><rect x="8" y="5" width="6" height="1.5" rx="0.5" fill="#8B5CF6"/><rect x="8" y="8" width="4" height="1" rx="0.5" fill="#8B5CF6" opacity="0.7"/></svg>
                </div>
                <div class="book-info">
                    <div class="book-title">Laskar Pelangi</div>
                    <div class="book-author">Andrea Hirata</div>
                    <span class="book-status status-borrowed">Dipinjam</span>
                </div>
                <div class="book-due">Kembali<br>15 Mei</div>
            </div>

            <div class="book-card">
                <div class="book-cover" style="background: #F59E0B;">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><rect x="4" y="2" width="10" height="18" rx="2" fill="white" opacity="0.9"/><rect x="8" y="5" width="6" height="1.5" rx="0.5" fill="#F59E0B"/><rect x="8" y="8" width="4" height="1" rx="0.5" fill="#F59E0B" opacity="0.7"/></svg>
                </div>
                <div class="book-info">
                    <div class="book-title">Bumi Manusia</div>
                    <div class="book-author">Pramoedya Ananta Toer</div>
                    <span class="book-status status-available">Tersedia</span>
                </div>
                <div class="book-due">Stok: 3</div>
            </div>

            <div class="book-card">
                <div class="book-cover" style="background: #10B981;">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><rect x="4" y="2" width="10" height="18" rx="2" fill="white" opacity="0.9"/><rect x="8" y="5" width="6" height="1.5" rx="0.5" fill="#10B981"/><rect x="8" y="8" width="4" height="1" rx="0.5" fill="#10B981" opacity="0.7"/></svg>
                </div>
                <div class="book-info">
                    <div class="book-title">Perahu Kertas</div>
                    <div class="book-author">Dee Lestari</div>
                    <span class="book-status status-returned">Dikembalikan</span>
                </div>
                <div class="book-due">2 hari lalu</div>
            </div>

            <div class="book-card">
                <div class="book-cover" style="background: #EF4444;">
                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"><rect x="4" y="2" width="10" height="18" rx="2" fill="white" opacity="0.9"/><rect x="8" y="5" width="6" height="1.5" rx="0.5" fill="#EF4444"/><rect x="8" y="8" width="4" height="1" rx="0.5" fill="#EF4444" opacity="0.7"/></svg>
                </div>
                <div class="book-info">
                    <div class="book-title">Dilan 1990</div>
                    <div class="book-author">Pidi Baiq</div>
                    <span class="book-status status-available">Tersedia</span>
                </div>
                <div class="book-due">Stok: 5</div>
            </div>
        </div>
    </div>
</section>

{{-- ─── FEATURES ─── --}}
<section class="features" id="fitur">
    <p class="section-label">Fitur Unggulan</p>
    <h2 class="section-title">Semua yang Anda Butuhkan</h2>
    <div class="features-grid">
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2C4A3E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2L3 7V12C3 16.55 7.33 20.74 12 22C16.67 20.74 21 16.55 21 12V7L12 2Z"/>
                </svg>
            </div>
            <div class="feature-name">Peminjaman Mudah</div>
            <p class="feature-desc">Pinjam buku hanya dalam beberapa klik. Proses cepat, mudah, dan tanpa antre.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2C4A3E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="9"/><polyline points="12 7 12 12 15 15"/>
                </svg>
            </div>
            <div class="feature-name">Pantau Tenggat</div>
            <p class="feature-desc">Notifikasi otomatis untuk mengingatkan batas waktu pengembalian buku Anda.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2C4A3E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 19.5A2.5 2.5 0 016.5 17H20"/><path d="M6.5 2H20V22H6.5A2.5 2.5 0 014 19.5V4.5A2.5 2.5 0 016.5 2Z"/>
                </svg>
            </div>
            <div class="feature-name">Katalog Lengkap</div>
            <p class="feature-desc">Ribuan koleksi buku dari berbagai genre tersedia dan siap untuk dipinjam.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2C4A3E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
            </div>
            <div class="feature-name">Cari Cepat</div>
            <p class="feature-desc">Temukan buku impian Anda dengan cepat melalui fitur pencarian dan filter kategori.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2C4A3E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21V19a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <div class="feature-name">Profil Anggota</div>
            <p class="feature-desc">Kelola profil, riwayat peminjaman, dan daftar favorit buku Anda dalam satu tempat.</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2C4A3E" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
            </div>
            <div class="feature-name">Riwayat Lengkap</div>
            <p class="feature-desc">Lacak semua aktivitas peminjaman Anda secara real-time dengan laporan yang jelas.</p>
        </div>
    </div>
</section>

{{-- ─── HOW IT WORKS ─── --}}
<section class="how-it-works">
    <p class="section-label">Cara Kerja</p>
    <h2 class="section-title">Mudah dalam 4 Langkah</h2>
    <div class="steps-grid">
        <div class="step-item">
            <div class="step-num">1</div>
            <div class="step-title">Daftar Akun</div>
            <p class="step-desc">Buat akun gratis Anda hanya dengan email dan password dalam hitungan detik.</p>
        </div>
        <div class="step-item">
            <div class="step-num">2</div>
            <div class="step-title">Cari Buku</div>
            <p class="step-desc">Telusuri ribuan koleksi buku kami berdasarkan judul, penulis, atau kategori.</p>
        </div>
        <div class="step-item">
            <div class="step-num">3</div>
            <div class="step-title">Pinjam</div>
            <p class="step-desc">Pilih buku dan konfirmasi peminjaman. Buku langsung tercatat di akun Anda.</p>
        </div>
        <div class="step-item">
            <div class="step-num">4</div>
            <div class="step-title">Kembalikan</div>
            <p class="step-desc">Kembalikan buku tepat waktu dan nikmati peminjaman berikutnya tanpa batas.</p>
        </div>
    </div>
</section>

{{-- ─── CTA ─── --}}
<section class="cta-section">
    <h2 class="cta-title">Mulai Membaca Hari Ini</h2>
    <p class="cta-desc">Bergabunglah dengan ribuan pembaca aktif dan nikmati akses ke koleksi buku terlengkap di perpustakaan digital kami.</p>
    <div class="cta-btns">
        @auth
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="btn-cta-primary">Dashboard Admin</a>
                <a href="{{ route('admin.peminjaman.index') }}" class="btn-cta-outline">Kelola Peminjaman</a>
            @else
                <a href="{{ route('user.buku.index') }}" class="btn-cta-primary">Cari Buku</a>
                <a href="{{ route('user.peminjaman.index') }}" class="btn-cta-outline">Peminjaman Saya</a>
            @endif
        @else
            <a href="{{ route('register') }}" class="btn-cta-primary">Daftar Gratis</a>
            <a href="{{ route('login') }}" class="btn-cta-outline">Sudah Punya Akun? Masuk</a>
        @endauth
    </div>
</section>

{{-- ─── FOOTER ─── --}}
<footer>
    <a href="{{ url('/') }}" class="footer-logo">
        <div class="logo-icon">
            <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
                <rect x="3" y="2" width="5" height="16" rx="1" fill="white" opacity="0.9"/>
                <rect x="9" y="2" width="5" height="16" rx="1" fill="white" opacity="0.7"/>
                <rect x="15" y="4" width="3" height="12" rx="1" fill="white" opacity="0.5"/>
            </svg>
        </div>
        <span class="footer-logo-text">Pustaka<span>Ku</span></span>
    </a>
    <p class="footer-copy">&copy; {{ date('Y') }} PustakaKu. Semua hak dilindungi.</p>
</footer>

</body>
</html>