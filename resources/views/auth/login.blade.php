<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - PustakaKu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;0,900;1,700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --green-dark: #1A2E27;
            --green-main: #2C4A3E;
            --green-soft: #5B8C7A;
            --green-pale: #E8F0ED;
            --green-light: #C5D5D0;
            --cream: #FAFAF7;
            --border: #E8E5DC;
            --text-muted: #6B7280;
            --text-subtle: #9CA3AF;
            --white: #FFFFFF;
            --red: #DC2626;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ─── LEFT PANEL ─── */
        .left-panel {
            background: var(--green-main);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .left-panel::before {
            content: '';
            position: absolute;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            bottom: -80px; left: -80px;
        }

        .left-panel::after {
            content: '';
            position: absolute;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            top: 60px; right: -40px;
        }

        .panel-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }

        .logo-icon {
            width: 38px; height: 38px;
            background: rgba(255,255,255,0.15);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 22px;
            font-weight: 700;
            color: var(--white);
        }

        .logo-text span { color: #9FCFC1; }

        .panel-middle {
            position: relative;
            z-index: 1;
        }

        .panel-tagline {
            font-family: 'Playfair Display', serif;
            font-size: 42px;
            font-weight: 900;
            color: var(--white);
            line-height: 1.15;
            margin-bottom: 1.2rem;
            letter-spacing: -0.5px;
        }

        .panel-tagline em {
            font-style: italic;
            color: #9FCFC1;
        }

        .panel-desc {
            font-size: 15px;
            color: rgba(255,255,255,0.6);
            line-height: 1.7;
            max-width: 340px;
        }

        /* Floating book cards */
        .book-stack {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 2.5rem;
        }

        .mini-book {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.07);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 12px 16px;
        }

        .mini-cover {
            width: 36px; height: 46px;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .mini-info { flex: 1; min-width: 0; }

        .mini-title {
            font-size: 13px;
            font-weight: 500;
            color: white;
            margin-bottom: 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .mini-author {
            font-size: 11px;
            color: rgba(255,255,255,0.45);
        }

        .mini-badge {
            font-size: 10px;
            font-weight: 500;
            padding: 3px 8px;
            border-radius: 20px;
            background: rgba(91,140,122,0.3);
            color: #9FCFC1;
            flex-shrink: 0;
        }

        .panel-bottom {
            font-size: 12px;
            color: rgba(255,255,255,0.3);
            position: relative;
            z-index: 1;
        }

        /* ─── RIGHT PANEL (FORM) ─── */
        .right-panel {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
        }

        .form-header {
            margin-bottom: 2.5rem;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 0.4rem;
            letter-spacing: -0.3px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--text-muted);
        }

        .form-subtitle a {
            color: var(--green-soft);
            text-decoration: none;
            font-weight: 500;
        }

        .form-subtitle a:hover { text-decoration: underline; }

        /* Error alert */
        .alert-error {
            background: #FEF2F2;
            border: 1px solid #FECACA;
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 1.5rem;
        }

        .alert-error ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .alert-error li {
            font-size: 13px;
            color: var(--red);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .alert-error li::before {
            content: '';
            width: 4px; height: 4px;
            border-radius: 50%;
            background: var(--red);
            flex-shrink: 0;
        }

        /* Status message */
        .alert-success {
            background: var(--green-pale);
            border: 1px solid var(--green-light);
            border-radius: 10px;
            padding: 12px 16px;
            margin-bottom: 1.5rem;
            font-size: 13px;
            color: var(--green-main);
        }

        /* Form fields */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--green-dark);
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            color: var(--green-dark);
            background: var(--white);
            transition: all 0.2s;
            outline: none;
        }

        .form-input:focus {
            border-color: var(--green-soft);
            box-shadow: 0 0 0 3px rgba(91,140,122,0.12);
        }

        .form-input.is-error { border-color: var(--red); }
        .form-input.is-error:focus { box-shadow: 0 0 0 3px rgba(220,38,38,0.1); }

        .field-error {
            font-size: 12px;
            color: var(--red);
            margin-top: 4px;
        }

        /* Password wrapper */
        .input-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-subtle);
            padding: 4px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .toggle-password:hover { color: var(--green-soft); }

        .input-wrapper .form-input { padding-right: 42px; }

        /* Remember + Forgot row */
        .form-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .remember-label input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: var(--green-main);
            cursor: pointer;
        }

        .forgot-link {
            font-size: 13px;
            color: var(--green-soft);
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-link:hover { text-decoration: underline; }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--green-main);
            color: var(--white);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 15px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover { background: var(--green-dark); transform: translateY(-1px); }
        .btn-submit:active { transform: translateY(0); }

        .divider {
            text-align: center;
            font-size: 12px;
            color: var(--text-subtle);
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: calc(50% - 30px);
            height: 1px;
            background: var(--border);
        }

        .divider::before { left: 0; }
        .divider::after { right: 0; }

        .register-cta {
            text-align: center;
            font-size: 14px;
            color: var(--text-muted);
        }

        .register-cta a {
            color: var(--green-main);
            font-weight: 500;
            text-decoration: none;
        }

        .register-cta a:hover { text-decoration: underline; }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            body { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

{{-- ─── LEFT PANEL ─── --}}
<div class="left-panel">
    <a href="{{ url('/') }}" class="panel-logo">
        <div class="logo-icon">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                <rect x="3" y="2" width="5" height="16" rx="1" fill="white" opacity="0.9"/>
                <rect x="9" y="2" width="5" height="16" rx="1" fill="white" opacity="0.7"/>
                <rect x="15" y="4" width="3" height="12" rx="1" fill="white" opacity="0.5"/>
            </svg>
        </div>
        <span class="logo-text">Pustaka<span>Ku</span></span>
    </a>

    <div class="panel-middle">
        <h2 class="panel-tagline">
            Selamat<br>Datang<br>
            <em>Kembali!</em>
        </h2>
        <p class="panel-desc">
            Masuk ke akun Anda dan lanjutkan perjalanan literasi bersama ribuan koleksi buku pilihan.
        </p>
        <div class="book-stack">
            <div class="mini-book">
                <div class="mini-cover" style="background:#8B5CF6;"></div>
                <div class="mini-info">
                    <div class="mini-title">Laskar Pelangi</div>
                    <div class="mini-author">Andrea Hirata</div>
                </div>
                <span class="mini-badge">Tersedia</span>
            </div>
            <div class="mini-book">
                <div class="mini-cover" style="background:#F59E0B;"></div>
                <div class="mini-info">
                    <div class="mini-title">Bumi Manusia</div>
                    <div class="mini-author">Pramoedya A. Toer</div>
                </div>
                <span class="mini-badge">Tersedia</span>
            </div>
            <div class="mini-book">
                <div class="mini-cover" style="background:#EF4444;"></div>
                <div class="mini-info">
                    <div class="mini-title">Dilan 1990</div>
                    <div class="mini-author">Pidi Baiq</div>
                </div>
                <span class="mini-badge">Tersedia</span>
            </div>
        </div>
    </div>

    <p class="panel-bottom">&copy; {{ date('Y') }} PustakaKu. Semua hak dilindungi.</p>
</div>

{{-- ─── RIGHT PANEL (FORM) ─── --}}
<div class="right-panel">
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">Masuk</h1>
            <p class="form-subtitle">
                Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a>
            </p>
        </div>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="alert-success">{{ session('status') }}</div>
        @endif

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="form-label">Alamat Email</label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="form-input {{ $errors->has('email') ? 'is-error' : '' }}"
                    placeholder="contoh@email.com"
                    required
                    autofocus
                    autocomplete="username"
                />
                @error('email')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input
                        id="password"
                        type="password"
                        name="password"
                        class="form-input {{ $errors->has('password') ? 'is-error' : '' }}"
                        placeholder="Masukkan password"
                        required
                        autocomplete="current-password"
                    />
                    <button type="button" class="toggle-password" onclick="togglePass()" aria-label="Tampilkan password">
                        <svg id="eye-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember me + Forgot --}}
            <div class="form-row">
                <label class="remember-label">
                    <input type="checkbox" name="remember" id="remember-me" {{ old('remember') ? 'checked' : '' }}>
                    Ingat saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                @endif
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn-submit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Masuk ke Akun
            </button>
        </form>

        <div class="divider">atau</div>

        <p class="register-cta">
            Belum terdaftar? <a href="{{ route('register') }}">Buat akun baru →</a>
        </p>
    </div>
</div>

<script>
    function togglePass() {
        const input = document.getElementById('password');
        const icon  = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
        }
    }
</script>
</body>
</html>