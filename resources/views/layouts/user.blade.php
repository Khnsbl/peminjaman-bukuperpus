<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Pustaka') — Pustaka</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* ── CSS Variables ── */
        :root {
            --brown:        #8B5E3C;
            --brown-deep:   #3D2510;
            --brown-dark:   #6B3F2A;
            --brown-light:  #C4956A;
            --gold:         #C9933A;
            --cream:        #F5EFE6;
            --cream-dark:   #EDE3D5;
            --cream-darker: #DDD0BC;
            --white:        #FDFAF6;
            --text-dark:    #2C1810;
            --text-mid:     #5C3D2E;
            --text-soft:    #8B6E5A;
            --text-muted:   #A89080;
            --sidebar-w:    240px;
            --radius:       16px;
            --radius-sm:    10px;
            --shadow-sm:    0 2px 8px rgba(61,37,16,.07);
            --shadow-md:    0 4px 20px rgba(61,37,16,.12);
        }

        * { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--cream);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--brown-deep) 0%, #2A1508 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: fixed;
            left: 0; top: 0; bottom: 0;
            z-index: 100;
        }

        .sidebar-brand {
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-logo {
            width: 44px; height: 44px;
            background: linear-gradient(135deg, var(--brown-light), var(--gold));
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; margin-bottom: 10px;
        }

        .sidebar-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px; font-weight: 700;
            color: white; letter-spacing: .3px;
        }

        .sidebar-sub {
            font-size: 9px; color: rgba(255,255,255,.4);
            letter-spacing: 1.5px; text-transform: uppercase;
            margin-top: 2px;
        }

        .sidebar-nav { padding: 16px 12px; flex: 1; }

        .nav-section {
            font-size: 9px; font-weight: 600;
            color: rgba(255,255,255,.3);
            letter-spacing: 1.5px; text-transform: uppercase;
            padding: 0 8px; margin: 16px 0 6px;
        }

        .nav-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            color: rgba(255,255,255,.6);
            font-size: 13px; font-weight: 500;
            text-decoration: none;
            transition: all .2s;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: rgba(255,255,255,.08);
            color: white;
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--brown-light), var(--brown));
            color: white;
            box-shadow: 0 4px 12px rgba(139,94,60,.4);
        }

        .nav-item i { width: 16px; text-align: center; font-size: 13px; }

        /* Sidebar footer (user info) */
        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid rgba(255,255,255,.08);
        }

        .sidebar-user {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 12px; border-radius: 10px;
            background: rgba(255,255,255,.05);
        }

        .sidebar-avatar {
            width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, var(--brown-light), var(--gold));
            display: flex; align-items: center; justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 13px; color: white; font-weight: 700;
        }

        .sidebar-user-name {
            font-size: 12px; font-weight: 600; color: white;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
            max-width: 120px;
        }

        .sidebar-user-role {
            font-size: 10px; color: rgba(255,255,255,.4);
            margin-top: 1px;
        }

        .sidebar-logout {
            background: none; border: none; cursor: pointer;
            color: rgba(255,255,255,.3); font-size: 14px;
            padding: 4px; margin-left: auto;
            transition: color .2s;
        }

        .sidebar-logout:hover { color: #e88; }

        /* ── Main Layout ── */
        .main-wrap {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* ── Topbar ── */
        .topbar {
            height: 64px;
            background: var(--white);
            border-bottom: 1px solid var(--cream-dark);
            display: flex; align-items: center;
            padding: 0 28px;
            gap: 12px;
            position: sticky; top: 0; z-index: 50;
            box-shadow: var(--shadow-sm);
        }

        .topbar-title {
            font-family: 'Playfair Display', serif;
            font-size: 17px; font-weight: 700;
            color: var(--brown-deep); flex: 1;
        }

        .topbar-sub {
            font-size: 12px; color: var(--text-muted);
            margin-top: 1px;
        }

        .topbar-btn {
            width: 36px; height: 36px; border-radius: 10px;
            border: 1px solid var(--cream-darker);
            background: var(--white);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-soft); cursor: pointer;
            transition: all .2s; font-size: 14px;
        }

        .topbar-btn:hover {
            background: var(--cream);
            color: var(--brown);
        }

        /* ── Page Content ── */
        .page-content {
            padding: 28px;
            flex: 1;
        }

        /* ── Cards ── */
        .card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--cream-darker);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--cream-dark);
            display: flex; align-items: center; justify-content: space-between;
        }

        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 15px; font-weight: 700;
            color: var(--brown-deep);
        }

        .card-body { padding: 20px 24px; }

        /* ── Badges ── */
        .badge {
            display: inline-flex; align-items: center; gap: 4px;
            padding: 3px 10px; border-radius: 20px;
            font-size: 11px; font-weight: 600;
        }

        .badge-green  { background: rgba(92,138,92,.12);  color: #4A7A4A; }
        .badge-red    { background: rgba(138,74,60,.12);  color: #8A4A3C; }
        .badge-gold   { background: rgba(201,147,58,.15); color: #A07020; }
        .badge-brown  { background: rgba(139,94,60,.12);  color: var(--brown-dark); }
        .badge-blue   { background: rgba(58,100,180,.12); color: #3A64B4; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; }

        table { width: 100%; border-collapse: collapse; }

        thead th {
            padding: 12px 16px;
            background: var(--cream);
            font-size: 11px; font-weight: 600;
            color: var(--text-soft);
            letter-spacing: .8px; text-transform: uppercase;
            text-align: left;
            border-bottom: 1px solid var(--cream-darker);
        }

        tbody td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--cream);
            vertical-align: middle;
            font-size: 13px;
        }

        tbody tr:hover { background: rgba(245,239,230,.5); }
        tbody tr:last-child td { border-bottom: none; }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 7px;
            padding: 8px 16px; border-radius: 9px;
            font-size: 13px; font-weight: 500;
            cursor: pointer; border: none;
            text-decoration: none; transition: all .2s;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--brown-light), var(--brown-dark));
            color: white;
            box-shadow: 0 2px 8px rgba(107,63,42,.3);
        }

        .btn-primary:hover { opacity: .9; transform: translateY(-1px); }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--cream-darker);
            color: var(--text-soft);
        }

        .btn-outline:hover { background: var(--cream); color: var(--brown); }

        .btn-danger {
            background: rgba(138,74,60,.1);
            color: #8A4A3C;
            border: 1px solid rgba(138,74,60,.2);
        }

        .btn-danger:hover { background: rgba(138,74,60,.2); }

        .btn-sm { padding: 5px 11px; font-size: 12px; border-radius: 7px; }

        /* ── Alert ── */
        .alert-success {
            padding: 12px 16px; margin-bottom: 20px;
            background: rgba(92,138,92,.1); border: 1px solid rgba(92,138,92,.3);
            border-radius: var(--radius-sm); color: #5C8A5C; font-size: 13px;
        }

        .alert-error {
            padding: 12px 16px; margin-bottom: 20px;
            background: rgba(138,74,60,.1); border: 1px solid rgba(138,74,60,.3);
            border-radius: var(--radius-sm); color: #8A4A3C; font-size: 13px;
        }

        /* ── Form ── */
        .form-label {
            display: block; font-size: 13px; font-weight: 500;
            color: var(--text-mid); margin-bottom: 6px;
        }

        .form-control {
            width: 100%; padding: 9px 13px;
            border: 1px solid var(--cream-darker);
            border-radius: 9px; font-size: 13px;
            color: var(--text-dark); background: var(--white);
            transition: border-color .2s, box-shadow .2s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--brown-light);
            box-shadow: 0 0 0 3px rgba(196,149,106,.15);
        }

        .form-group { margin-bottom: 16px; }

        /* ── Animations ── */
        .fade-up {
            animation: fadeUp .4s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="sidebar-logo">📚</div>
        <div class="sidebar-title">Pustaka</div>
        <div class="sidebar-sub">Sistem Perpustakaan</div>
    </div>

    <nav class="sidebar-nav">
        <div class="nav-section">Utama</div>

        <a href="{{ route('user.dashboard') }}"
           class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-house"></i> Dashboard
        </a>

        <div class="nav-section">Perpustakaan</div>

        <a href="{{ route('user.buku.index') }}"
           class="nav-item {{ request()->routeIs('user.buku.*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Daftar Buku
        </a>

        <a href="{{ route('user.peminjaman.index') }}"
           class="nav-item {{ request()->routeIs('user.peminjaman.*') ? 'active' : '' }}">
            <i class="fas fa-rotate"></i> Peminjaman Saya
        </a>

        <div class="nav-section">Akun</div>

        <a href="{{ route('user.profile.show') }}"
           class="nav-item {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
            <i class="fas fa-user"></i> Profil Saya
        </a>
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="flex:1; min-width:0;">
                <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                <div class="sidebar-user-role">Member</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout" title="Logout">
                    <i class="fas fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </div>
</aside>

<!-- Main -->
<div class="main-wrap">

    <!-- Topbar -->
    <header class="topbar">
        <div style="flex:1;">
            <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
            <div class="topbar-sub">@yield('page-sub', '')</div>
        </div>
        <button class="topbar-btn" title="Notifikasi">
            <i class="fas fa-bell"></i>
        </button>
        <button class="topbar-btn" title="Pencarian">
            <i class="fas fa-magnifying-glass"></i>
        </button>
    </header>

    <!-- Content -->
    <main class="page-content">

        @if(session('success'))
        <div class="alert-success fade-up">
            <i class="fas fa-circle-check" style="margin-right:6px;"></i>
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert-error fade-up">
            <i class="fas fa-circle-xmark" style="margin-right:6px;"></i>
            {{ session('error') }}
        </div>
        @endif

        @yield('content')
    </main>

</div>

@stack('scripts')
</body>
</html>