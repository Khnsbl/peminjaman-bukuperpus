<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Pustaka</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --cream:        #FAF6EE;
            --cream-dark:   #F0E8D8;
            --cream-darker: #E5D9C5;
            --brown-light:  #C4956A;
            --brown:        #8B5E3C;
            --brown-dark:   #5C3D22;
            --brown-deep:   #3D2510;
            --gold:         #C9933A;
            --gold-light:   #E8B96A;
            --text-dark:    #2C1810;
            --text-mid:     #5C3D22;
            --text-soft:    #8B6E5A;
            --text-muted:   #B09080;
            --white:        #FFFDF8;
            --shadow-sm:    0 2px 8px rgba(61,37,16,.08);
            --shadow-md:    0 4px 20px rgba(61,37,16,.12);
            --shadow-lg:    0 8px 40px rgba(61,37,16,.16);
            --radius:       16px;
            --radius-sm:    10px;
            --sidebar-w:    270px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ══════════════════════════════════════
           SIDEBAR
        ══════════════════════════════════════ */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--brown-deep);
            position: fixed;
            top: 0; left: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow: hidden;
            transition: transform .3s ease;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            opacity: .6;
        }

        .sidebar-brand {
            padding: 28px 28px 20px;
            border-bottom: 1px solid rgba(255,255,255,.07);
            position: relative;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, var(--gold), var(--brown-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--white);
            margin-bottom: 12px;
            box-shadow: 0 4px 16px rgba(201,147,58,.4);
        }

        .brand-title {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--white);
            letter-spacing: -.3px;
            line-height: 1;
        }

        .brand-sub {
            font-size: 11px;
            color: rgba(255,255,255,.4);
            margin-top: 4px;
            letter-spacing: .5px;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 16px;
            overflow-y: auto;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: rgba(255,255,255,.25);
            padding: 0 12px;
            margin: 16px 0 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            color: rgba(255,255,255,.6);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
            position: relative;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: rgba(255,255,255,.06);
            color: rgba(255,255,255,.9);
        }

        .nav-item.active {
            background: linear-gradient(90deg, rgba(201,147,58,.2), rgba(201,147,58,.08));
            color: var(--gold-light);
            border-left: 3px solid var(--gold);
            padding-left: 11px;
        }

        .nav-item .nav-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            background: rgba(255,255,255,.05);
            flex-shrink: 0;
            transition: all .2s;
        }

        .nav-item.active .nav-icon {
            background: rgba(201,147,58,.25);
            color: var(--gold);
        }

        .nav-badge {
            margin-left: auto;
            background: var(--gold);
            color: var(--brown-deep);
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,.07);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: var(--radius-sm);
            background: rgba(255,255,255,.05);
        }

        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--gold), var(--brown));
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 15px;
            color: var(--white);
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--white);
            line-height: 1.2;
        }

        .user-role {
            font-size: 11px;
            color: var(--gold-light);
        }

        .logout-btn {
            margin-left: auto;
            width: 30px;
            height: 30px;
            border-radius: 8px;
            background: rgba(255,255,255,.06);
            border: none;
            color: rgba(255,255,255,.4);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .logout-btn:hover { background: rgba(220,80,80,.2); color: #ff8080; }

        /* ══════════════════════════════════════
           MAIN CONTENT
        ══════════════════════════════════════ */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            height: 70px;
            background: var(--white);
            border-bottom: 1px solid var(--cream-darker);
            display: flex;
            align-items: center;
            padding: 0 32px;
            gap: 16px;
            position: sticky;
            top: 0;
            z-index: 50;
            box-shadow: var(--shadow-sm);
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 600;
            color: var(--brown-deep);
            flex: 1;
        }

        .topbar-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 400;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .topbar-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: none;
            background: var(--cream-dark);
            color: var(--text-mid);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            transition: all .2s;
            position: relative;
        }

        .topbar-btn:hover { background: var(--cream-darker); color: var(--brown); }

        .notif-dot {
            position: absolute;
            top: 7px; right: 7px;
            width: 7px; height: 7px;
            background: var(--gold);
            border-radius: 50%;
            border: 2px solid var(--white);
        }

        .page-content {
            flex: 1;
            padding: 32px;
        }

        /* ══════════════════════════════════════
           CARDS & COMPONENTS
        ══════════════════════════════════════ */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow-sm);
            border: 1px solid var(--cream-darker);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--cream-dark);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 16px;
            font-weight: 600;
            color: var(--brown-deep);
        }

        .card-body { padding: 24px; }

        /* Stat Card */
        .stat-card {
            background: var(--white);
            border-radius: var(--radius);
            padding: 22px 24px;
            border: 1px solid var(--cream-darker);
            box-shadow: var(--shadow-sm);
            position: relative;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-md);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: 0; right: 0;
            width: 100px; height: 100px;
            border-radius: 50%;
            transform: translate(30%, -30%);
            opacity: .08;
        }

        .stat-card.brown::after  { background: var(--brown); }
        .stat-card.gold::after   { background: var(--gold); }
        .stat-card.green::after  { background: #5C8A5C; }
        .stat-card.red::after    { background: #8A4A3C; }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 16px;
        }

        .stat-card.brown .stat-icon { background: rgba(139,94,60,.12); color: var(--brown); }
        .stat-card.gold  .stat-icon { background: rgba(201,147,58,.12); color: var(--gold); }
        .stat-card.green .stat-icon { background: rgba(92,138,92,.12);  color: #5C8A5C; }
        .stat-card.red   .stat-icon { background: rgba(138,74,60,.12);  color: #8A4A3C; }

        .stat-value {
            font-family: 'Playfair Display', serif;
            font-size: 30px;
            font-weight: 700;
            color: var(--brown-deep);
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-label { font-size: 13px; color: var(--text-soft); font-weight: 500; }

        .stat-trend {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 10px;
            padding: 3px 8px;
            border-radius: 20px;
        }

        .stat-trend.up   { background: rgba(92,138,92,.1); color: #5C8A5C; }
        .stat-trend.down { background: rgba(138,74,60,.1); color: #8A4A3C; }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: var(--radius-sm);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .2s;
        }

        .btn-primary  { background: var(--brown); color: var(--white); }
        .btn-primary:hover { background: var(--brown-dark); color: var(--white); }

        .btn-gold     { background: var(--gold); color: var(--brown-deep); }
        .btn-gold:hover { background: var(--gold-light); }

        .btn-outline  { background: transparent; border: 1.5px solid var(--cream-darker); color: var(--text-mid); }
        .btn-outline:hover { border-color: var(--brown-light); color: var(--brown); }

        .btn-danger   { background: rgba(138,74,60,.1); color: #8A4A3C; }
        .btn-danger:hover { background: rgba(138,74,60,.2); }

        .btn-sm { padding: 7px 14px; font-size: 13px; }

        /* Table */
        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; font-size: 14px; }

        thead th {
            background: var(--cream);
            color: var(--text-soft);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .8px;
            text-transform: uppercase;
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid var(--cream-darker);
        }

        tbody tr { border-bottom: 1px solid var(--cream-dark); transition: background .15s; }
        tbody tr:hover { background: var(--cream); }
        tbody tr:last-child { border-bottom: none; }

        td { padding: 14px 16px; color: var(--text-dark); vertical-align: middle; }

        /* Badge */
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-green  { background: rgba(92,138,92,.12);  color: #3A6B3A; }
        .badge-gold   { background: rgba(201,147,58,.12); color: #8B5E00; }
        .badge-red    { background: rgba(138,74,60,.12);  color: #7A2A1A; }
        .badge-brown  { background: rgba(139,94,60,.12);  color: var(--brown-dark); }
        .badge-blue   { background: rgba(60,90,138,.12);  color: #1A3A6B; }

        /* Form controls */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-mid);
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            border: 1.5px solid var(--cream-darker);
            background: var(--cream);
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--text-dark);
            transition: border .2s, box-shadow .2s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--brown-light);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(139,94,60,.08);
        }

        /* Search */
        .search-wrap { position: relative; }
        .search-wrap i { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 14px; }
        .search-wrap .form-control { padding-left: 38px; }

        /* Pagination */
        .pagination { display: flex; align-items: center; gap: 6px; list-style: none; }

        .pagination .page-item .page-link {
            width: 34px; height: 34px;
            border-radius: 8px;
            border: 1.5px solid var(--cream-darker);
            display: flex; align-items: center; justify-content: center;
            font-size: 13px; font-weight: 500;
            color: var(--text-mid);
            text-decoration: none;
            background: var(--white);
            transition: all .2s;
        }

        .pagination .page-item.active .page-link { background: var(--brown); border-color: var(--brown); color: var(--white); }
        .pagination .page-item .page-link:hover { border-color: var(--brown-light); color: var(--brown); }

        /* Alert */
        .alert {
            padding: 14px 18px;
            border-radius: var(--radius-sm);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .alert-success { background: rgba(92,138,92,.1); color: #2A5C2A; border-left: 4px solid #5C8A5C; }
        .alert-danger  { background: rgba(138,74,60,.1); color: #7A2A1A; border-left: 4px solid #8A4A3C; }

        /* Modal */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(61,37,16,.6);
            backdrop-filter: blur(4px);
            z-index: 200;
            display: none;
            align-items: center; justify-content: center;
        }

        .modal-overlay.open { display: flex; }

        .modal-box {
            background: var(--white);
            border-radius: var(--radius);
            width: 100%; max-width: 520px;
            box-shadow: var(--shadow-lg);
            overflow: hidden;
            animation: modalIn .3s ease;
        }

        @keyframes modalIn {
            from { opacity: 0; transform: translateY(20px) scale(.97); }
            to   { opacity: 1; transform: none; }
        }

        .modal-header {
            padding: 20px 24px 16px;
            border-bottom: 1px solid var(--cream-dark);
            display: flex; align-items: center; justify-content: space-between;
        }

        .modal-title { font-family: 'Playfair Display', serif; font-size: 18px; font-weight: 600; color: var(--brown-deep); }

        .modal-close {
            width: 32px; height: 32px;
            border-radius: 8px; border: none;
            background: var(--cream-dark); color: var(--text-soft);
            cursor: pointer; display: flex; align-items: center; justify-content: center;
            transition: all .2s;
        }

        .modal-close:hover { background: var(--cream-darker); color: var(--text-dark); }
        .modal-body   { padding: 24px; }
        .modal-footer { padding: 16px 24px; border-top: 1px solid var(--cream-dark); display: flex; gap: 10px; justify-content: flex-end; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--cream-darker); border-radius: 10px; }

        /* Animations */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: none; }
        }

        .fade-up  { animation: fadeUp .5s ease both; }
        .delay-1  { animation-delay: .08s; }
        .delay-2  { animation-delay: .16s; }
        .delay-3  { animation-delay: .24s; }
        .delay-4  { animation-delay: .32s; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: none; }
            .main-wrap { margin-left: 0; }
            .page-content { padding: 20px 16px; }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- ═══ SIDEBAR ═══ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="fas fa-book-open"></i></div>
        <div class="brand-title">Pustaka</div>
        <div class="brand-sub">Sistem Manajemen Perpustakaan</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section-label">Utama</div>

        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-house"></i></span>
            Dashboard
        </a>

        <div class="nav-section-label">Kelola</div>

        <a href="{{ route('admin.buku.index') }}" class="nav-item {{ request()->routeIs('admin.buku.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-book"></i></span>
            Kelola Buku
        </a>

        <a href="{{ route('admin.kategoris.index') }}" class="nav-item {{ request()->routeIs('admin.kategoris.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-tags"></i></span>
            Kategori
        </a>

        <a href="{{ route('admin.peminjaman.index') }}" class="nav-item {{ request()->routeIs('admin.peminjaman.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-hand-holding-heart"></i></span>
            Peminjaman
        </a>

        <div class="nav-section-label">Sistem</div>

        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-users"></i></span>
            Pengguna
        </a>

        {{-- Route laporan belum tersedia, aktifkan jika sudah dibuat --}}
        {{-- <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
            <span class="nav-icon"><i class="fas fa-chart-pie"></i></span>
            Laporan
        </a> --}}

    </nav>

    <div class="sidebar-footer">
        <div class="user-card">
            <div class="user-avatar">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</div>
            <div>
                <div class="user-name">{{ auth()->user()->name ?? 'Admin' }}</div>
                <div class="user-role">Administrator</div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="logout-btn" type="submit" title="Logout">
                    <i class="fas fa-arrow-right-from-bracket" style="font-size:13px"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- ═══ MAIN ═══ -->
<div class="main-wrap">
    <header class="topbar">
        <div>
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-subtitle">@yield('page-sub', 'Selamat datang kembali!')</div>
        </div>

        <div class="topbar-actions">
            <button class="topbar-btn" title="Notifikasi">
                <i class="fas fa-bell"></i>
                <span class="notif-dot"></span>
            </button>
            <button class="topbar-btn" title="Pencarian">
                <i class="fas fa-magnifying-glass"></i>
            </button>
        </div>
    </header>

    <!-- Flash Messages -->
    <div style="padding: 0 32px; margin-top: 24px;">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-circle-xmark"></i>
                {{ session('error') }}
            </div>
        @endif
    </div>

    <main class="page-content">
        @yield('content')
    </main>
</div>

<script>
    document.querySelector('.topbar-btn')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('open');
    });

    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(el => {
            el.style.transition = 'opacity .4s';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 400);
        });
    }, 4000);
</script>

@stack('scripts')
</body>
</html>